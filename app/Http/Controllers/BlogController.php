<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BlogController extends Controller
{

public function index()
{
    try {

        // Show everything: active, inactive, and soft-deleted blogs.
        $blogs = Blog::withTrashed()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Blogs fetched successfully',
            'count' => $blogs->count(),
            'data' => $blogs
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch blogs',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function updateStatus(Request $request, $id)
{
    try {

        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $blog = Blog::findOrFail($id);
        $blog->is_active = $request->boolean('is_active');
        $blog->save();

        return response()->json([
            'status' => true,
            'message' => 'Blog status updated successfully',
            'data' => $blog
        ], 200);

    } catch (ValidationException $e) {

        return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);

    } catch (ModelNotFoundException $e) {

        return response()->json([
            'status' => false,
            'message' => 'Blog not found'
        ], 404);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Failed to update blog status',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function show($id)
{

    try {

        // withTrashed() so a single blog can be viewed even if soft-deleted.
        $blog = Blog::withTrashed()->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Blog fetched successfully',
            'data' => $blog
        ], 200);

    } catch (ModelNotFoundException $e) {

        return response()->json([
            'status' => false,
            'message' => 'Blog not found'
        ], 404);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch blog',
            'error' => $e->getMessage()
        ], 500);
    }
}



public function showBySlug($slug)
{

    try {

        // withTrashed() so a single blog can be viewed even if soft-deleted.
        $blog = Blog::withTrashed()->where('blog_slug', $slug)->firstOrFail();


        return response()->json([
            'status' => true,
            'message' => 'Blog fetched successfully',
            'data' => $blog
        ], 200);

    } catch (ModelNotFoundException $e) {

        return response()->json([
            'status' => false,
            'message' => 'Blog not found'
        ], 404);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch blog',
            'error' => $e->getMessage()
        ], 500);
    }
}



public function featured(Request $request)
{
    try {

        $category = $request->query('category');

        // Featured, active, non-deleted blogs, newest first.
        $query = Blog::where('is_featured', true)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc');

        // The single global "main featured" blog (active, non-deleted), if any.
        $mainFeatured = Blog::where('is_main_featured', true)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->first();

        // ?category=Tech → the single latest featured blog in that category.
        if ($category) {
            $blog = $query->where('blog_category', $category)->first();

            $this->encryptId($blog);

            return response()->json([
                'status' => true,
                'message' => 'Featured blog fetched successfullywee',
                'category' => $category,
                // When a main featured blog exists, show it for every category.
                'data' => $mainFeatured ?: $blog
            ], 200);
        }

        // No filter → one featured blog per category (the latest, since ordered desc).
        $blogs = $query->get()
            ->groupBy('blog_category')
            ->map(fn ($group) => $group->first())
            ->values();

        return response()->json([
            'status' => true,
            'message' => 'Featured blogs fetched successfully',
            'count' => $blogs->count(),
            // When a main featured blog exists, show it instead of the list.
            'data' => $mainFeatured ?: $blogs
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch featured blogs',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function byCategory(Request $request)
{
    try {

        $category = $request->query('category');

        // ?category=Tech  → only that category's blogs (flat list)
        if ($category) {
            $blogs = Blog::where('blog_category', $category)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Blogs fetched successfully',
                'category' => $category,
                'count' => $blogs->count(),
                'data' => $blogs
            ], 200);
        }

        // No filter → all blogs grouped by category: { "Tech": [...], "News": [...] }
        $blogs = Blog::orderBy('created_at', 'desc')->get();


        $grouped = $blogs->groupBy('blog_category');

        return response()->json([
            'status' => true,
            'message' => 'Blogs fetched successfully',
            'data' => $grouped
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch blogs',
            'error' => $e->getMessage()
        ], 500);
    }
}

/**
 * Replace a single blog's numeric id with an encrypted id in the output.
 */
private function encryptId($blog): void
{
    if ($blog) {
        $blog->encrypted_id = Crypt::encryptString((string) $blog->id);
        $blog->makeHidden('id');
    }
}

/**
 * Replace each blog's numeric id with an encrypted id in the output.
 */
private function encryptIds($blogs): void
{
    $blogs->each(fn ($blog) => $this->encryptId($blog));
}

/**
 * Decrypt an encrypted id back to the numeric id. Returns null if invalid.
 */
private function decryptId($value): ?int
{
    try {
        return (int) Crypt::decryptString($value);
    } catch (\Throwable $e) {
        return null;
    }
}

public function update(Request $request, $id)
{
    try {

        // Partial update: every field is optional, but if sent it must be valid.
        $request->validate([
            'blog_title' => 'sometimes|required|string',
            'blog_slug' => [
                'sometimes', 'nullable', 'string', 'max:255',
                // Unique among active blogs only, ignoring this blog itself; a
                // soft-deleted blog's slug stays reusable.
                Rule::unique('blogs', 'blog_slug')->whereNull('deleted_at')->ignore($id),
            ],
            'blog_category' => 'sometimes|required|string',
            'blog_date' => 'nullable|date',
            'blog_description' => 'sometimes|required',
            'blog_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240', // max 10MB
            'blog_tags' => 'nullable|array',
            'blog_tags.*' => 'string',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'is_main_featured' => 'nullable|boolean',
            'is_restore' => 'nullable|boolean',
        ]);

        // withTrashed() so a soft-deleted blog can still be updated.
        $blog = Blog::withTrashed()->findOrFail($id);

        if ($request->has('blog_title')) {
            $blog->blog_title = $request->blog_title;
        }
        if ($request->has('blog_slug')) {
            $blog->blog_slug = $request->blog_slug ?: Str::slug($request->blog_title ?? $blog->blog_title);
        }
        if ($request->has('blog_category')) {
            $blog->blog_category = $request->blog_category;
        }
        if ($request->has('blog_date')) {
            $blog->blog_date = $request->blog_date ?: now()->toDateString();
        }
        if ($request->has('blog_description')) {
            $blog->blog_description = $request->blog_description;
        }
        if ($request->has('blog_tags')) {
            $blog->blog_tags = $request->blog_tags ? implode(',', $request->blog_tags) : null;
        }
        if ($request->has('is_active')) {
            $blog->is_active = $request->boolean('is_active');
        }
        if ($request->has('is_featured')) {
            if ($request->boolean('is_featured')) {
                // Only one featured blog per category. If another blog in the
                // same category is already featured, don't switch — return that
                // blog so the frontend can show which one is active.
                $existing = Blog::where('is_featured', true)
                    ->where('blog_category', $blog->blog_category)
                    ->where('id', '!=', $blog->id)
                    ->first();

                if ($existing) {
                    return response()->json([
                        'status'   => false,
                        // Discriminator so the frontend knows which rule was hit.
                        'conflict' => 'category_featured',
                        'category' => $blog->blog_category,
                        'message'  => "A featured blog already exists for the '{$blog->blog_category}' category. Unset it before featuring another.",
                        'active_featured' => [
                            'id'            => $existing->id,
                            'blog_title'    => $existing->blog_title,
                            'blog_slug'     => $existing->blog_slug,
                            'blog_category' => $existing->blog_category,
                        ],
                        'data' => $existing,
                    ], 409);
                }

                $blog->is_featured = true;
            } else {
                $blog->is_featured = false;
            }
        }
        if ($request->has('is_main_featured')) {
            if ($request->boolean('is_main_featured')) {
                // Only one blog can be the main featured one. If another already
                // holds it, don't switch — return the existing main featured blog
                // so the frontend can show/link to the one that's currently active.
                $existing = Blog::where('is_main_featured', true)
                    ->where('id', '!=', $blog->id)
                    ->first();

                if ($existing) {
                    return response()->json([
                        'status'   => false,
                        // Discriminator so the frontend knows which rule was hit.
                        'conflict' => 'main_featured',
                        'message'  => 'A main featured blog already exists. Unset it before featuring another.',
                        'active_main_featured' => [
                            'id'         => $existing->id,
                            'blog_title' => $existing->blog_title,
                            'blog_slug'  => $existing->blog_slug,
                        ],
                        'data' => $existing,
                    ], 409);
                }

                $blog->is_main_featured = true;
            } else {
                $blog->is_main_featured = false;
            }
        }

        // Restore a soft-deleted blog only when the user explicitly sends is_restore = true.
        if ($request->boolean('is_restore') && $blog->trashed()) {
            $blog->restore();
        }

        // Replace the image only when a new file is uploaded; remove the old one.
        if ($request->hasFile('blog_image')) {
            if ($blog->blog_image && File::exists(public_path($blog->blog_image))) {
                File::delete(public_path($blog->blog_image));
            }

            $image = $request->file('blog_image');
            $fileName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/blogs'), $fileName);
            $blog->blog_image = 'uploads/blogs/' . $fileName;
        }

        $blog->save();

        return response()->json([
            'status' => true,
            'message' => 'Blog updated successfully',
            'data' => $blog
        ], 200);

    } catch (ValidationException $e) {

        return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);

    } catch (ModelNotFoundException $e) {

        return response()->json([
            'status' => false,
            'message' => 'Blog not found'
        ], 404);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Failed to update blog',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function destroy($id)
{
    try {

        $blog = Blog::findOrFail($id);
        $blog->delete(); // soft delete: sets deleted_at, row is kept

        return response()->json([
            'status' => true,
            'message' => 'Blog deleted successfully'
        ], 200);

    } catch (ModelNotFoundException $e) {

        return response()->json([
            'status' => false,
            'message' => 'Blog not found'
        ], 404);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Failed to delete blog',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function store(Request $request)
{
    try {

        // Resolve the slug (use the provided one, else derive from the title)
        // so the uniqueness check runs against the value we'll actually store.
        $request->merge([
            'blog_slug' => $request->blog_slug ?: Str::slug((string) $request->blog_title),
        ]);

        $request->validate([
            'blog_title' => 'required|string',
            'blog_slug' => [
                'required', 'string', 'max:255',
                // Unique among active blogs only; a soft-deleted blog's slug is reusable.
                Rule::unique('blogs', 'blog_slug')->whereNull('deleted_at'),
            ],
            'blog_category' => 'required|string',
            'blog_date' => 'nullable|date',
            'blog_description' => 'required',
            'blog_image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:10240', // max 10MB
            'blog_tags' => 'nullable|array',
            'blog_tags.*' => 'string',
            'is_featured' => 'nullable|boolean',
        ], [
            'blog_slug.unique'   => 'This blog slug already exists. Please choose a different one.',
            'blog_slug.required' => 'A blog slug is required (it could not be generated from the title).',
        ]);

        $user = $request->user();

        $image = $request->file('blog_image');
        $fileName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/blogs'), $fileName);
        $imagePath = 'uploads/blogs/' . $fileName;

        $blog = Blog::create([
            'blog_title' => $request->blog_title,
            'blog_slug' => $request->blog_slug ?: Str::slug($request->blog_title),
            'blog_category' => $request->blog_category,
            'blog_date' => $request->blog_date ?: now()->toDateString(),
            'blog_author' => $user->name ?? $user->email,
            'blog_description' => $request->blog_description,
            'blog_image' => $imagePath,
            // Accept tags as an array and store them as a comma-separated string.
            'blog_tags' => $request->blog_tags ? implode(',', $request->blog_tags) : null,
            'is_active' => false,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Blog created successfully',
            'data' => $blog
        ], 201);

    } catch (ValidationException $e) {

        return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Failed to create blog',
            'error' => $e->getMessage()
        ], 500);
    }
}
}