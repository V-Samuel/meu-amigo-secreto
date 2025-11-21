import './bootstrap';
import Alpine from 'alpinejs';

// ===============================================
// 1. Importar o GSAP e o ScrollTrigger
// ===============================================
import { gsap } from 'gsap';
import { ScrollTrigger } from "gsap/ScrollTrigger"; // <-- Importa o plugin
import Lenis from '@studio-freight/lenis';

// ===============================================
// 2. Registrar o plugin
// ===============================================
gsap.registerPlugin(ScrollTrigger); // <-- Registra o plugin no GSAP


// 3. (OPCIONAL) Tornar ambos globais para usar em tags <script>
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger; // <-- Torna o ScrollTrigger global

// 4. Inicializar o Lenis (Scroll Suave)
const lenis = new Lenis();
function raf(time) {
  lenis.raf(time);
  requestAnimationFrame(raf);
}
requestAnimationFrame(raf);

// 5. Inicializar o Alpine (DEVE VIR POR ÚLTIMO)
window.Alpine = Alpine;
Alpine.start();

// 6. Animações da Página Inicial (Welcome)
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('landing-hero')) {
        gsap.from('#landing-hero-title', { opacity: 0, y: 50, duration: 1, delay: 0.3 });
        gsap.from('#landing-hero-subtitle', { opacity: 0, y: 20, duration: 0.8, delay: 0.6 });
        gsap.from('#landing-hero-cta', { opacity: 0, y: 20, duration: 0.8, delay: 0.8 });
        gsap.from('#landing-hero-image', { opacity: 0, scale: 0.8, duration: 1, delay: 0.5 });

        gsap.from("#features-section .feature-card", {
            scrollTrigger: {
                trigger: "#features-section",
                start: "top 80%",
                toggleActions: "play none none none",
            },
            opacity: 0, y: 50, duration: 0.8, stagger: 0.2
        });
    }
});