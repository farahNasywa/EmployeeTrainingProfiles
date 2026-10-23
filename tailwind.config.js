const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    extend: {
      fontFamily: {
        sans: ['InterVariable', ...defaultTheme.fontFamily.sans],
      },
      animation: {
        'fade-in': 'fadeIn 0.4s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: 0, transform: 'scale(0.95)' },
          '100%': { opacity: 1, transform: 'scale(1)' },
        },
      },
      colors: {
        lemon: '#E9EE9E',
        primary: "#0F3387",
        secondary: "#C2CFEF",
        lightGray: "#F5F5F5",
        darkGray: "#D0D1D3",
      },
      spacing: {
        '4.5': '1.125rem',
      },
    },
  },
}
