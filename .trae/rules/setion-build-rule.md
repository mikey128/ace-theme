build the module replicated the design accurately as shown in uploaded image 

1. layout and style 
Same as uploaded image


2. Dynamic data (Carbon Fields)
Use Carbon Fields to define fields.

Fields required:
Section-level settings
1) enable_full_width (checkbox / boolean)
If enabled → section wrapper width = 100%
If disabled → section wrapper uses container max-width
2) hide_section (checkbox / boolean)
If enabled → do NOT render this module on frontend


3. Frontend rendering requirements
Create a PHP render template (e.g. template-parts/section-name.php):
If hide_section is true → return early (do not output HTML)
Wrapper logic:
If enable_full_width is true:
use w-full px-6
Else:
use max-w-7xl mx-auto px-6 max-w-global


4. Tailwind & markup rules
Semantic HTML
Mobile-first
Clean, reusable class structure

5. Output expectations
Please generate:
Carbon Fields PHP code (fields definition)
Frontend render PHP template
