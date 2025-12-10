import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import { globSync } from "glob";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                ...globSync("resources/js/**/*.js"), // Include all JS files
                ...globSync("resources/css/**/*.css"), // Include all CSS files
                ...globSync("resources/scss/**/*.scss"), // Include all SCSS files
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
