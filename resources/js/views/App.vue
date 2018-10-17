<template>
    <div>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <router-link class="navbar-brand" :to="{ name: 'welcome' }">Application Tests</router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="main-nav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'images' }">Image Preview Tool</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'notes' }">Note Taking App</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container" style="margin-top:25px;">

            <router-view></router-view>

        </div>

    </div>
</template>
<script>
export default {}
</script>
