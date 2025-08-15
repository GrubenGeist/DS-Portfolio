// resources/types/troika-three-text.d.ts
import * as THREE from 'three';

declare module 'troika-three-text' {
  export class Text extends THREE.Mesh<THREE.BufferGeometry, THREE.Material> {
    text: string;
    font: string;                 // .woff/.ttf/.otf URL
    fontSize: number;             // Welt-Einheiten
    color: number | string;       // hex oder css
    anchorX: number | 'left' | 'center' | 'right';
    anchorY: number | 'top' | 'top-baseline' | 'middle' | 'bottom-baseline' | 'bottom';

    maxWidth?: number;
    lineHeight?: number;
    letterSpacing?: number;
    textAlign?: 'left' | 'center' | 'right' | 'justify';
    direction?: 'ltr' | 'rtl' | 'auto';
    depthOffset?: number;
    curveRadius?: number;

    // Outline/FX (optional)
    outlineWidth?: number;
    outlineColor?: number | string;
    outlineBlur?: number;
    outlineOffsetX?: number;
    outlineOffsetY?: number;

    sync(cb?: () => void): void;
  }

  export function preloadFont(options: {
    font: string;
    characters?: string;
  }): Promise<void>;
}
