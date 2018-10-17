<template>
    <div id="">
        <h3>Page Description</h3>
        This page shows the proposed solutions for the required tests for:<br />
        <a href="https://stackoverflow.com/jobs/204945/lead-full-stack-developer-brandboom">
            https://stackoverflow.com/jobs/204945/lead-full-stack-developer-brandboom
        </a>

        <hr />
        <h3><router-link :to="{ name: 'images' }">Image Preview Tool</router-link></h3>
        Create an image preview tool that can be used to preview images, with the following preferred methods:

        <ul>
            <li>Drag and Drop: The image is dragged from the computer and dropped on the previewer.</li>
            <li>Image Link: The image link is provided.</li>
        </ul>

        Additional functionality by applicant:
        <ul>
            <li>Upload on drop.</li>
            <li>Add an image zoom box that can be controlled by minus (-) and plus (+) buttons</li>
            <li>Provide also the stored image url.</li>
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
            <li>Pagination</li>
            <li>Filter the number of notes that can be viewed per page</li>
            <li>Sort by title or date</li>
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
