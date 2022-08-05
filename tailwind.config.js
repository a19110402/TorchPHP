module.exports = {
  content: ["./resources/**/*.blade.php"],
  theme: {
    extend: {
      colors: {
        'azul-primario': 'rgba(54, 55, 149, 1)',
        'azul-secundario': 'rgba(54, 55, 149, 0.4)',
        'azul-terciario': 'rgba(54, 55, 149, 0.2)',
        'amarillo': 'rgb(251, 176, 64)',
        'negro': 'rgb(35, 31 , 32)',
        'blanco': 'rgb(255, 255, 255)',
      },
      screens: {
        'sm': '576px',
        // => @media (min-width: 576px) { ... }
  
        'md': '960px',
        'md2': '1044px',
        // => @media (min-width: 960px) { ... }
  
        'lg': '1200px',
        // => @media (min-width: 1440px) { ... }
      },
    },
  },
  plugins: [],
}
