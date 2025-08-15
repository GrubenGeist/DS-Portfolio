import type axiosType from 'axios';
declare global {
  interface Window { axios: typeof axiosType; }
}
export {};
