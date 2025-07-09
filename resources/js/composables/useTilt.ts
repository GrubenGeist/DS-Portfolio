import { ref, onMounted, onUnmounted, type Ref } from 'vue';

// Diese Funktion ist unser Composable. Es nimmt eine Referenz auf ein HTML-Element entgegen.
export function useTilt(elementRef: Ref<HTMLElement | null>) {
  // Konfiguration für den Effekt
  const maxTilt = 8; // Maximale Neigung in Grad

  const handleMouseMove = (event: MouseEvent) => {
    if (!elementRef.value) return;

    const { clientX, clientY } = event;
    const { left, top, width, height } = elementRef.value.getBoundingClientRect();

    // Berechne die Mausposition relativ zur Mitte der Karte (von -0.5 bis +0.5)
    const x = (clientX - left) / width - 0.5;
    const y = (clientY - top) / height - 0.5;

    // Berechne die Rotation basierend auf der Mausposition
    // Die y-Mausposition steuert die x-Rotation und umgekehrt, für ein intuitives Gefühl.
    const rotateX = -y * maxTilt;
    const rotateY = x * maxTilt;

    // Wende die Transformationen an: 3D-Perspektive, Rotation und das "Abheben" (scale)
    elementRef.value.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.05, 1.05, 1.05)`;
  };

  const handleMouseLeave = () => {
    if (!elementRef.value) return;
    // Setze die Transformation zurück, wenn die Maus die Karte verlässt
    elementRef.value.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
  };

  // onMounted und onUnmounted sind Vue-Lifecycle-Hooks.
  // Wir stellen sicher, dass die Event-Listener nur hinzugefügt werden, wenn die Komponente im DOM ist,
  // und wieder entfernt werden, wenn sie verschwindet, um Speicherlecks zu vermeiden.
  onMounted(() => {
    if (elementRef.value) {
      elementRef.value.addEventListener('mousemove', handleMouseMove);
      elementRef.value.addEventListener('mouseleave', handleMouseLeave);
    }
  });

  onUnmounted(() => {
    if (elementRef.value) {
      elementRef.value.removeEventListener('mousemove', handleMouseMove);
      elementRef.value.removeEventListener('mouseleave', handleMouseLeave);
    }
  });
}