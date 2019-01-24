<template>
    <div class="container">
        <p>Create new accessory .</p>
        <form v-on:submit.prevent="save()">
            <label>Model:</label>
            <input v-model="accessory.model" type="text">
            <label>Type:</label>
            <select v-model="accessory.type_id">
                <option v-for="type in types" :value="type.id">{{ type.name }}</option>
            </select>
            <label>Workplace:</label>
            <select v-model="accessory.workplace_id">
                <option v-for="workplace in workplaces" :value="workplace.id">{{ workplace.mark}}</option>
            </select>
            <label>Mark:</label>
            <input v-model="accessory.mark" type="text">
            <label>Purchase year:</label>
            <input v-model="accessory.purchase_year" type="number" min="1900" max="2099" step="1">
            <label>Value:</label>
            <input v-model="accessory.value" type="number" min="0.00" max="10000.00" step="0.01">
            <label>Description:</label>
            <textarea v-model="accessory.description"></textarea>


            <button class="btn">Add</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                accessory: {
                    type_id: '',
                    workplace_id: '',
                    model: '',
                    mark: '',
                    purchase_year: '',
                    value: '',
                    description: ''
                },
                types: [],
                workplaces: [],
            }
        },
        methods: {
            save: function () {
                window.axios({
                    method: 'post',
                    url: '/api/accessories',
                    data: this.accessory
                }).then(response => {
                    console.log(response)
                }).catch(error => {
                    console.log(error.response.data)
                });
            },
            fetchTypes: function () {
                window.axios({
                    method: 'get',
                    url: '/api/types'
                }).then(response => {
                    this.types = response.data
                    console.log(response)
                });
            },
            fetchWorkplaces: function () {
                window.axios({
                    method: 'get',
                    url: '/api/workplaces'
                }).then(response => {
                    this.workplaces = response.data
                    console.log(response)
                });
            },
        },
        mounted() {
            console.log('Component mounted.')
            this.fetchWorkplaces()
            this.fetchTypes()
        }
    }
</script>