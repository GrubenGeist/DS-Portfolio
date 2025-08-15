// resources/js/types/gtag.d.ts
declare global {
  interface Window {
    dataLayer: any[];
    gtag: (...args: any[]) => void; // zusätzlich
  }
  function gtag(...args: any[]): void;
}
export {};
