<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Seed the blogs table.
     */
    public function run(): void
    {
        $blogs = [
            [
                'blog_slug' => 'we-just-hosted-our-first-all-hands-heres-why-it-matters',
                'blog_title' => "We Just Hosted Our First All-Hands — Here's Why It Matters",
                'blog_author' => 'Infotech.Works Team',
                'blog_date' => '2025-05-29',
                'blog_category' => 'Events',
                'blog_image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&q=80',
                'blog_description' => <<<'HTML'
                    <p>At Infotech.Works, we believe that building a great company starts with building a great team. That's why we recently hosted our very first All-Hands meeting—a milestone moment that brought together every member of our organization, from developers to designers, from project managers to leadership.</p>

                    <h2>Why All-Hands Meetings Matter</h2>
                    <p>In a world where remote work and distributed teams are becoming the norm, creating moments of genuine connection has never been more important. An All-Hands meeting isn't just about sharing updates or presenting metrics—it's about reinforcing our shared mission and celebrating our collective achievements.</p>

                    <h2>What We Covered</h2>
                    <p>During our first All-Hands, we discussed our company vision, celebrated recent project wins, recognized outstanding team members, and outlined our roadmap for the coming quarters. But more importantly, we created space for open dialogue, questions, and genuine connection.</p>

                    <h2>Looking Ahead</h2>
                    <p>This first All-Hands was just the beginning. We're committed to making these gatherings a regular part of our culture—because when everyone understands where we're headed and why, we move faster and stronger together.</p>

                    <p>Here's to many more all-hands—and to building something meaningful, together.</p>
                    HTML,
            ],
            [
                'blog_slug' => 'how-fintech-companies-are-revolutionizing-mobile-app-development',
                'blog_title' => 'How Fintech Companies Are Revolutionizing Mobile App Development',
                'blog_author' => 'Infotech.Works Team',
                'blog_date' => '2025-05-15',
                'blog_category' => 'News',
                'blog_image' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800&q=80',
                'blog_description' => <<<'HTML'
                    <p>The financial technology sector is experiencing unprecedented growth, and at the heart of this revolution is mobile app development. Today's consumers expect seamless, secure, and intuitive mobile experiences for managing their finances.</p>

                    <h2>The Fintech Mobile Revolution</h2>
                    <p>From digital banking to cryptocurrency trading, peer-to-peer payments to investment platforms, fintech mobile apps are transforming how people interact with money. These apps must deliver enterprise-grade security while maintaining consumer-friendly usability.</p>

                    <h2>Key Challenges in Fintech App Development</h2>
                    <ul>
                      <li><strong>Security First:</strong> Implementing multi-layer authentication, encryption, and fraud detection</li>
                      <li><strong>Regulatory Compliance:</strong> Navigating complex financial regulations across different markets</li>
                      <li><strong>Real-Time Processing:</strong> Handling high-volume transactions with minimal latency</li>
                      <li><strong>User Experience:</strong> Making complex financial operations simple and intuitive</li>
                    </ul>

                    <h2>Our Approach</h2>
                    <p>At Infotech.Works, we specialize in building secure, high-performance mobile applications tailored for fast-moving industries like Fintech. Our team combines deep technical expertise with financial domain knowledge to deliver solutions that meet the highest standards of security and performance.</p>

                    <p>Whether you're a startup disrupting traditional banking or an established institution modernizing your digital offerings, we're here to help you build the future of finance.</p>
                    HTML,
            ],
            [
                'blog_slug' => 'developing-e-commerce-mobile-and-web-applications',
                'blog_title' => 'Developing E-Commerce Mobile and Web Applications',
                'blog_author' => 'Infotech.Works Team',
                'blog_date' => '2025-05-10',
                'blog_category' => 'News',
                'blog_image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&q=80',
                'blog_description' => <<<'HTML'
                    <p>E-commerce has evolved far beyond simple online catalogs. Today's successful platforms deliver personalized, omnichannel experiences that meet customers wherever they are—on web, mobile, or in-store.</p>

                    <h2>The Modern E-Commerce Landscape</h2>
                    <p>With mobile commerce accounting for over 70% of e-commerce traffic, having a robust mobile strategy is no longer optional. Consumers expect fast load times, intuitive navigation, seamless checkout, and personalized recommendations.</p>

                    <h2>Essential Features for E-Commerce Success</h2>
                    <ul>
                      <li><strong>Mobile-First Design:</strong> Responsive layouts that prioritize the mobile experience</li>
                      <li><strong>Smart Search & Filters:</strong> AI-powered product discovery and recommendations</li>
                      <li><strong>Streamlined Checkout:</strong> One-click purchasing and multiple payment options</li>
                      <li><strong>Inventory Management:</strong> Real-time stock updates across all channels</li>
                      <li><strong>Analytics & Insights:</strong> Data-driven decision making for optimization</li>
                    </ul>

                    <h2>Why Choose Infotech.Works</h2>
                    <p>At Infotech.Works, we don't just build apps—we build experiences that convert. Our team has delivered e-commerce solutions for businesses of all sizes, from boutique startups to enterprise retailers.</p>

                    <p>Whether you're just starting out or looking to modernize your current platform, we're here to bring your e-commerce vision to life.</p>
                    HTML,
            ],
            [
                'blog_slug' => 'partner-with-infotech-works-for-endless-opportunities',
                'blog_title' => 'Partner with Infotech.Works for Endless Opportunities',
                'blog_author' => 'Infotech.Works Team',
                'blog_date' => '2025-04-28',
                'blog_category' => 'News',
                'blog_image' => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=800&q=80',
                'blog_description' => <<<'HTML'
                    <p>In today's rapidly evolving digital landscape, finding the right technology partner can make the difference between market leadership and playing catch-up. At Infotech.Works, we pride ourselves on being more than just a software development company.</p>

                    <h2>Your Innovation Partner</h2>
                    <p>We work alongside your team to identify opportunities, solve complex challenges, and bring innovative ideas to life. Our collaborative approach ensures that every solution we build is aligned with your business goals and market needs.</p>

                    <h2>Your Product Enabler</h2>
                    <p>From initial concept to market launch, we provide end-to-end product development services. Our expertise spans mobile apps, web platforms, cloud infrastructure, and emerging technologies like AI and blockchain.</p>

                    <h2>Your Growth Accelerator</h2>
                    <p>We understand that speed matters. Our agile methodologies and experienced teams help you move faster without sacrificing quality. Whether you need to scale quickly or pivot strategically, we're ready to support your growth journey.</p>

                    <h2>Partnership Models</h2>
                    <p>We offer flexible engagement models to suit your needs—from dedicated development teams to project-based engagements to technology consulting. Let's explore how we can work together to unlock endless opportunities for your business.</p>
                    HTML,
            ],
            [
                'blog_slug' => 'how-infotech-works-is-helping-global-clients-embrace-the-mobile-future',
                'blog_title' => 'How Infotech.Works is Helping Global Clients Embrace the Mobile Future',
                'blog_author' => 'Infotech.Works Team',
                'blog_date' => '2025-04-20',
                'blog_category' => 'News',
                'blog_image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&q=80',
                'blog_description' => <<<'HTML'
                    <p>The mobile revolution is reshaping every industry, and businesses worldwide are racing to deliver exceptional mobile experiences. At Infotech.Works, we're proud to be at the forefront of this transformation, helping clients across the globe build mobile solutions that drive real business results.</p>

                    <h2>Global Reach, Local Expertise</h2>
                    <p>Our team works with clients across North America, Europe, Asia, and beyond. We combine global best practices with deep understanding of local markets to deliver solutions that resonate with users everywhere.</p>

                    <h2>Industries We Serve</h2>
                    <ul>
                      <li><strong>Healthcare:</strong> Patient engagement apps, telemedicine platforms, health tracking solutions</li>
                      <li><strong>Finance:</strong> Mobile banking, investment platforms, payment solutions</li>
                      <li><strong>Retail:</strong> E-commerce apps, loyalty programs, in-store experiences</li>
                      <li><strong>Logistics:</strong> Fleet management, delivery tracking, warehouse optimization</li>
                    </ul>

                    <h2>Our Mobile Technology Stack</h2>
                    <p>We leverage cutting-edge technologies including React Native, Flutter, Swift, and Kotlin to build cross-platform and native applications that deliver exceptional performance and user experience.</p>

                    <p>At Infotech.Works, we believe that the right technology can transform businesses. Partner with us and drive tomorrow's innovation today!</p>
                    HTML,
            ],
            [
                'blog_slug' => 'react-native-revolutionizing-multi-platform-mobile-app-development',
                'blog_title' => 'React Native: Revolutionizing Multi-Platform Mobile App Development',
                'blog_author' => 'Infotech.Works Team',
                'blog_date' => '2025-04-12',
                'blog_category' => 'News',
                'blog_image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&q=80',
                'blog_description' => <<<'HTML'
                    <p>React Native has emerged as one of the most powerful frameworks for building mobile applications that work seamlessly across iOS and Android platforms. By enabling code sharing while maintaining native performance, React Native is revolutionizing how companies approach mobile development.</p>

                    <h2>Why React Native?</h2>
                    <ul>
                      <li><strong>Code Reusability:</strong> Write once, deploy on both iOS and Android with up to 90% code sharing</li>
                      <li><strong>Native Performance:</strong> React Native compiles to native components, ensuring smooth performance</li>
                      <li><strong>Faster Development:</strong> Hot reloading and a vast ecosystem of libraries accelerate development</li>
                      <li><strong>Cost Efficiency:</strong> Single codebase means reduced development and maintenance costs</li>
                      <li><strong>Strong Community:</strong> Backed by Facebook and a thriving open-source community</li>
                    </ul>

                    <h2>Success Stories</h2>
                    <p>Major companies like Facebook, Instagram, Airbnb, and Uber Eats have leveraged React Native to deliver world-class mobile experiences. The framework continues to evolve with new features and performance improvements.</p>

                    <h2>Our React Native Expertise</h2>
                    <p>At Infotech.Works, we specialize in helping startups, small, medium and big enterprises leverage React Native to create exceptional cross-platform applications. Our experienced team has delivered dozens of React Native projects across various industries.</p>

                    <p>Ready to build your next mobile app with React Native? Let's talk about how we can bring your vision to life.</p>
                    HTML,
            ],
            [
                'blog_slug' => 'infotech-works-announces-mobile-dedicated-development-centre',
                'blog_title' => 'Infotech.Works Announces A Mobile Dedicated Development Centre',
                'blog_author' => 'Infotech.Works Team',
                'blog_date' => '2025-04-05',
                'blog_category' => 'News',
                'blog_image' => 'https://images.unsplash.com/photo-1497215842964-222b430dc094?w=800&q=80',
                'blog_description' => <<<'HTML'
                    <p>We are excited to announce the launch of our new Mobile Dedicated Development Centre (MDC)—a specialized facility focused entirely on mobile application development and innovation.</p>

                    <h2>What is the Mobile Dedicated Development Centre?</h2>
                    <p>Our MDC brings together the best mobile development talent, cutting-edge tools, and proven methodologies under one roof. This dedicated center allows us to deliver even higher quality mobile solutions with faster turnaround times.</p>

                    <h2>Key Capabilities</h2>
                    <ul>
                      <li><strong>Cross-Platform Development:</strong> Expert teams in React Native and Flutter</li>
                      <li><strong>Native Development:</strong> Specialized iOS (Swift) and Android (Kotlin) developers</li>
                      <li><strong>UI/UX Design:</strong> Mobile-first design specialists</li>
                      <li><strong>Quality Assurance:</strong> Dedicated mobile testing and QA teams</li>
                      <li><strong>DevOps:</strong> CI/CD pipelines optimized for mobile deployment</li>
                    </ul>

                    <h2>Benefits for Our Clients</h2>
                    <p>The MDC enables us to offer dedicated mobile development teams that can scale with your needs. Whether you need a small team for a startup MVP or a large team for enterprise-scale projects, our MDC model provides flexibility and expertise.</p>

                    <p>Contact us to learn more about how our Mobile Dedicated Development Centre can accelerate your mobile strategy.</p>
                    HTML,
            ],
            [
                'blog_slug' => 'infotech-works-unveils-new-state-of-the-art-office-in-pune-india',
                'blog_title' => 'Infotech.Works Unveils Its New State-of-the-Art Office in Pune, India',
                'blog_author' => 'Infotech.Works Team',
                'blog_date' => '2025-03-28',
                'blog_category' => 'News',
                'blog_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&q=80',
                'blog_description' => <<<'HTML'
                    <p>We are thrilled to announce the grand opening of our new state-of-the-art office in Pune, India! This milestone marks an exciting new chapter in our company's growth and our commitment to delivering world-class technology solutions.</p>

                    <h2>A Space Designed for Innovation</h2>
                    <p>Our new Pune office has been thoughtfully designed to foster creativity, collaboration, and innovation. The modern workspace features open floor plans, dedicated collaboration zones, quiet focus areas, and cutting-edge technology infrastructure.</p>

                    <h2>Facility Highlights</h2>
                    <ul>
                      <li><strong>Modern Workspaces:</strong> Ergonomic furniture and natural lighting throughout</li>
                      <li><strong>Collaboration Zones:</strong> Meeting rooms and breakout spaces for team discussions</li>
                      <li><strong>Tech Infrastructure:</strong> High-speed connectivity and state-of-the-art equipment</li>
                      <li><strong>Employee Amenities:</strong> Cafeteria, recreation areas, and wellness facilities</li>
                      <li><strong>Green Design:</strong> Sustainable building practices and energy-efficient systems</li>
                    </ul>

                    <h2>Growing Our Team</h2>
                    <p>This new facility positions us to significantly expand our team in Pune. We're actively hiring talented engineers, designers, and project managers who want to work on challenging projects for global clients.</p>

                    <p>We invite our clients, partners, and the Pune tech community to visit our new office. Here's to new beginnings and continued growth!</p>
                    HTML,
            ],
        ];

        foreach ($blogs as $blog) {
            // updateOrCreate keyed on the slug keeps this idempotent.
            Blog::updateOrCreate(
                ['blog_slug' => $blog['blog_slug']],
                array_merge($blog, [
                    'author_id' => 1,
                    'is_active' => true,
                    'is_featured' => false,
                    'is_main_featured' => false,
                ])
            );
        }
    }
}
