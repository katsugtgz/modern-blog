/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  safelist: [
    'bg-red-50',
    'text-red-500',
    'bg-yellow-50',
    'text-yellow-500',
    'bg-green-50',
    'text-green-500',
    'bg-blue-50',
    'text-blue-500',
  ],
  theme: {
    extend: {
      typography: {
        DEFAULT: {
          css: {
            maxWidth: '100%',
            a: {
              color: '#4f46e5',
              '&:hover': {
                color: '#4338ca',
              },
            },
          },
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
  ],
} 