<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Custom Meta -->
    @yield('meta_seo')

    <!-- Icon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />

    <title>Mini CMS</title>

    <!-- Library -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Aleo:ital,wght@0,100..900;1,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Css -->
    <style>
        .tab-btn {
            position: relative;
        }

        .tab-btn.active-tab {
            color: #111827;
            font-weight: 600;
        }

        .tab-btn.active-tab::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 2px;
            width: 100%;
            background-color: #facc15;
        }

        body {
            font-family: 'Montserrat', sans-serif;
        }

        .btn-animate:active {
            transform: scale(0.95);
        }
    </style>

    <!-- Cart -->
    <link rel="stylesheet" href="{{ asset('assets/cart/style.css') }}">

    @yield('css')
</head>

<body class="bg-white text-gray-800">
    <!-- Navbar -->
    @include('users.layouts.navbar')

    @yield('content')

    <footer class="bg-blue-900 text-blue-100 pt-12 pb-10">
        <div class="container mx-auto px-4">
            <!-- Deskripsi -->
            <div class="col-span-full">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-6 h-6 bg-yellow-400 rounded-full"></div>
                    <h3 class="text-xl font-bold text-white"> Mini CMS</h3>
                </div>
                <p class="text-sm leading-relaxed">
                    Mini CMS adalah sistem manajemen konten sederhana yang dirancang untuk kebutuhan dasar pengelolaan artikel.
                    Dengan Mini CMS, pengguna dapat <span class="font-semibold">membuat dan memposting artikel</span>,
                    <span class="font-semibold">membaca dan melihat konten</span>, serta <span class="font-semibold">meninggalkan komentar</span>
                    pada artikel yang tersedia. Fungsionalitas inti ini membuat Mini CMS ringan, mudah digunakan, dan cocok untuk blog pribadi
                    atau proyek kecil yang tidak memerlukan fitur kompleks seperti CMS besar pada umumnya.
                </p>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-blue-700 mt-10 pt-4 text-center text-sm">
            &copy; {{ date('Y') }} Toton Gendut. All rights reserved.
        </div>
    </footer>

    <script>
        const buttons = document.querySelectorAll("[data-filter]");
        const cards = document.querySelectorAll(".product-card");

        buttons.forEach((btn) => {
            btn.addEventListener("click", () => {
                const filter = btn.getAttribute("data-filter");

                // Update class aktif pada tombol
                buttons.forEach((b) => b.classList.remove("active-tab"));
                btn.classList.add("active-tab");

                // Filter produk
                cards.forEach((card) => {
                    if (filter === "all" || card.classList.contains(filter)) {
                        card.classList.remove("hidden");
                    } else {
                        card.classList.add("hidden");
                    }
                });
            });
        });
    </script>

    <script>
        const btn = document.getElementById('hamburger');
        const menu = document.getElementById('mobileMenu');
        let isOpen = false;

        btn.addEventListener('click', () => {
            isOpen = !isOpen;

            if (isOpen) {
                menu.classList.remove('max-h-0');
                menu.classList.add('max-h-[500px]');
            } else {
                menu.classList.remove('max-h-[500px]');
                menu.classList.add('max-h-0');
            }
        });

        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.location.pathname !== "/") {
                    e.preventDefault();
                    window.location.href = "/" + this.getAttribute('href');
                }
            });
        });
    </script>

    <!-- Other Script -->
    @yield('script')
</body>

</html>