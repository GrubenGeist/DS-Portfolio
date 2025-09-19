import { onMounted, onUnmounted, type Ref } from 'vue';

export function useTilt(elementRef: Ref<HTMLElement | null>) {
    const maxTilt = 8;

    // Prüfen ob Gerät ein Smartphone/Tablet ist
    const isMobile = () => /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

    const isIOS = () => /iPad|iPhone|iPod/.test(navigator.userAgent);

    // --- Maussteuerung (nur Desktop) ---
    const handleMouseMove = (event: MouseEvent) => {
        if (!elementRef.value) return;

        const { clientX, clientY } = event;
        const { left, top, width, height } = elementRef.value.getBoundingClientRect();

        const x = (clientX - left) / width - 0.5;
        const y = (clientY - top) / height - 0.5;

        const rotateX = -y * maxTilt;
        const rotateY = x * maxTilt;

        elementRef.value.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.05,1.05,1.05)`;
    };

    const handleMouseLeave = () => {
        if (!elementRef.value) return;
        elementRef.value.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1,1,1)';
    };

    // --- Gyroskopsteuerung (nur Android) ---
    const handleOrientation = (event: DeviceOrientationEvent) => {
        if (!elementRef.value) return;

        const beta = event.beta ?? 0;
        const gamma = event.gamma ?? 0;

        const rotateX = Math.max(-maxTilt, Math.min(maxTilt, beta / 10));
        const rotateY = Math.max(-maxTilt, Math.min(maxTilt, gamma / 10));

        elementRef.value.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1,1,1)`;
    };

    // --- Lifecycle ---
    onMounted(() => {
        if (elementRef.value) {
            elementRef.value.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1,1,1)';

            if (!isMobile()) {
                // Desktop → Maussteuerung
                elementRef.value.addEventListener('mousemove', handleMouseMove);
                elementRef.value.addEventListener('mouseleave', handleMouseLeave);
            }
        }

        if (isMobile() && !isIOS() && window.DeviceOrientationEvent) {
            // Mobile Android → Gyro
            window.addEventListener('deviceorientation', handleOrientation);
        }
        // zum Device Testen
        console.log('Mode:', isMobile() ? (isIOS() ? 'iOS' : 'Android') : 'Desktop');
    });

    onUnmounted(() => {
        if (elementRef.value) {
            elementRef.value.removeEventListener('mousemove', handleMouseMove);
            elementRef.value.removeEventListener('mouseleave', handleMouseLeave);
        }
        window.removeEventListener('deviceorientation', handleOrientation);
    });
}
