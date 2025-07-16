// /resources/js/lib/loadScript.ts

export function loadScript(src: string, id: string): Promise<void> {
  return new Promise((resolve, reject) => {
    // Prüfe, ob das Skript schon existiert, um doppeltes Laden zu vermeiden
    if (document.getElementById(id)) {
      resolve();
      return;
    }

    const script = document.createElement('script');
    script.src = src;
    script.id = id;
    script.async = true;

    script.onload = () => resolve();
    script.onerror = () => reject(new Error(`Failed to load script: ${src}`));

    document.head.appendChild(script);
  });
}