<template>
    <div id="">
        <h3>Page Description</h3>
        This page shows the proposed solutions for the required tests for:<br />
        <a href="https://stackoverflow.com/jobs/204945/lead-full-stack-developer-brandboom">
            https://stackoverflow.com/jobs/204945/lead-full-stack-developer-brandboom
        </a>
        <br />
        With was made with the following stack:
        PHP 7.2 - Laravel 5.7, Vue.js 2, Vue Router, Bootstrap 4, MomentJs, Lodash, Font Awesome 4.7, MySQL 5.7.<br />
        It also uses jQuery for some functionality but i try to keep it on vanilla js.

        <hr />
        <h3><router-link :to="{ name: 'images' }">Image Preview Tool</router-link></h3>
        Create an image preview tool that can be used to preview images, with the following preferred methods:

        <ul>
            <li>Drag and Drop: The image is dragged from the computer and dropped on the previewer.</li>
            <li>Image Link: The image link is provided.</li>
        </ul>

        Additional functionality by applicant:
        <ul>
            <li>Image gallery with pagination to control navigation.</li>
            <li>"Image zoom box" to see image details, this can be controlled by minus (-) and plus (+) buttons.</li>
            <li>Delete the image.</li>
        </ul>

        <hr />

        <h3><router-link :to="{ name: 'notes' }">Note Taking App</router-link></h3>
        Create a simple note-taking app. You should be able to:

        <ul>
            <li>Add a note</li>
            <li>Edit a note</li>
            <li>Delete a note</li>
        </ul>

        Also make sure that:
        <ul>
            <li>Each note should look like a colored rectangular box.</li>
            <li>Boxes can be colored in different colors, selected from a fixed list of colors.</li>
        </ul>

        Additional functionality by applicant:
        <ul>
            <li>Emulation of macOS notes app</li>
            <li>Folders functionality</li>
            <li>Create folder</li>
            <li>Edit folder</li>
            <li>Search by string</li>
            <li>Auto save</li>
        </ul>

    </div>
</template>
<script>
export default {
    name: "",
    data: () => ({

    })
}
</script>
<style lang="scss" scoped>
</style>
