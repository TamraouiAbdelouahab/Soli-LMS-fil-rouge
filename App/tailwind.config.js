import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./modules/**/Resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },

            colors: {
                "charcoal-900": "#1E1E1E",
                "teal-50": "#F0FAFB",
                "teal-100": "#CCF2F5",
                "teal-200": "#99E5EA",
                "teal-400": "#33C6D6",
                "teal-500": "#00B3C6",
                "teal-600": "#00B3C6",
                "teal-700": "#008A9B",
                "teal-800": "#006B7A",
                "teal-900": "#006B7A",
                "light-blue-25": "#FAFBFC",
                "light-blue-50": "#F5F7FB",
                "light-blue-100": "#E8EDF5",
                "light-blue-200": "#D1DCE8",
                "light-blue-400": "#BCCCE5",
                "light-blue-600": "#9BB5D6",
                "red-orange": "#FF5F33",
                "red-orange-100": "#FFE5DF",
                "red-orange-200": "#FFCBBF",
                "red-orange-800": "#CC4C29",
                "golden-yellow": "#D99200",
                "golden-yellow-50": "#FFFBF0",
                "golden-yellow-100": "#FFF4CC",
                "golden-yellow-200": "#FFE999",
                "golden-yellow-700": "#B37700",
                "golden-yellow-800": "#996600",
                "bright-yellow": "#FFDD33",
                "bright-yellow-100": "#FFF9CC",
            },
        },
    },

    plugins: [forms],
};
