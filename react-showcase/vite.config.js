import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vitejs.dev/config/
// IMPORTANT: Update the base path to match your GitHub repository name
// For example, if your repo is 'my-pokemon-app', change it to '/my-pokemon-app/'
// If deploying to root domain, use '/'
export default defineConfig({
  plugins: [react()],
  base: process.env.NODE_ENV === 'production' ? '/pokeapi_clopes/' : '/',
})
