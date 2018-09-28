<template>
    <p v-if="errorMessage">{{ errorMessage }}</p>
    <form v-on:submit.prevent="onSubmit">
        <div class="input-wrapper">
            <input type="text" v-model.trim="title" id="title" required>
            <label for="title">Feature name</label>
        </div>
        <button role="button">Add</button>
    </form>
</template>

<script>
    export default {
        name: "FeatureForm",
        props: ['hackathon', 'idea'],
        data() {
            return {
                title: null,
            }
        }
    }
</script>

<style scoped>

</style>
