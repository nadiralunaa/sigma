document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll(".input-field");
    const toggle_btn = document.querySelectorAll(".toggle");
    const main = document.querySelector("main");
    const bullets = document.querySelectorAll(".bullets span");
    const images = document.querySelectorAll(".image");

    inputs.forEach((inp) => {
        inp.addEventListener("focus", () => {
            inp.classList.add("active");
        });
        inp.addEventListener("blur", () => {
            if (inp.value != "") return;
            inp.classList.remove("active");
        });
    });

    toggle_btn.forEach((btn) => {
        btn.addEventListener("click", () => {
            main.classList.toggle("sign-up-mode");
        });
    });

    function moveSlider() {
        let index = this.dataset.value;

        let currentImage = document.querySelector(`.img-${index}`);
        images.forEach((img) => img.classList.remove("show"));
        currentImage.classList.add("show");

        const textSlider = document.querySelector(".text-group");
        textSlider.style.transform = `translateY(${-(index - 1) * 2.2}rem)`;

        bullets.forEach((bull) => bull.classList.remove("active"));
        this.classList.add("active");
    }

    bullets.forEach((bullet) => {
        bullet.addEventListener("click", moveSlider);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const images = document.querySelectorAll('.image');
    const bullets = document.querySelectorAll('.bullets span');

    let currentImageIndex = 0;

    // Menampilkan gambar pertama dan bullet pertama saat halaman dimuat
    images[currentImageIndex].classList.add('show');
    bullets[currentImageIndex].classList.add('active');

    // Fungsi untuk menampilkan gambar berikutnya pada slider
    function showNextImage() {
        images[currentImageIndex].classList.remove('show');
        bullets[currentImageIndex].classList.remove('active');

        currentImageIndex = (currentImageIndex + 1) % images.length;

        images[currentImageIndex].classList.add('show');
        bullets[currentImageIndex].classList.add('active');
    }

    // Mengatur interval untuk menampilkan gambar berikutnya setiap 3 detik
    setInterval(showNextImage, 3000);

    // Mengatur fungsi untuk menampilkan gambar berdasarkan bullet yang diklik
    bullets.forEach((bullet, index) => {
        bullet.addEventListener('click', () => {
            images[currentImageIndex].classList.remove('show');
            bullets[currentImageIndex].classList.remove('active');

            currentImageIndex = index;

            images[currentImageIndex].classList.add('show');
            bullets[currentImageIndex].classList.add('active');
        });
    });
});
