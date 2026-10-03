import re
import sys

filepath = r'wp-content/themes/rashtrotthana/page-about-us.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

replacement = r'''<!-- ============================================================
       4. ROTATING PHOTO SECTION
       ============================================================ -->
    <section class="rs-about-section" id="timeline-section">
        <div class="rs-container">
            <div class="rs-about-section-header text-center">
                <h2>Our Centers</h2>
            </div>
            <div class="rs-card-grid rs-gallery-grid" style="grid-template-columns: repeat(4, 1fr);">
                <?php 
                 = rs_get_centers();
                foreach ( as ) {
                    if (preg_match('/(Sadashiva|Jayanagar|Kundalahalli|Kundanalli|Chamaraj)/i', ['name'])) {
                        echo '<img src="' . esc_url(['image']) . '" alt="' . esc_attr(['name']) . '" loading="lazy" style="width:100%; height:250px; object-fit:cover; border-radius:12px;">';
                    }
                }
                ?>
            </div>
        </div>
    </section>'''

# Replace timeline section
content = re.sub(r'<!-- =+\s*4\. JOURNEY TIMELINE SECTION\s*=+\s*-->\s*<section class="rs-about-section rs-timeline-section" id="timeline-section">.*?</section>', replacement, content, flags=re.DOTALL)

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)
