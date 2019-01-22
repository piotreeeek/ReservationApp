<template>
    <div class="container">
        <p>Create new accessory .</p>
        <form v-on:submit.prevent="save()">
            <lable>Model:</lable>
            <input v-model="accessory.model" type="text">
            <lable>Mark:</lable>
            <input v-model="accessory.mark" type="text">
            <lable>Purchase year:</lable>
            <input v-model="accessory.purchase_year" type="number" min="1900" max="2099" step="1">
            <lable>Value:</lable>
            <input v-model="accessory.value" type="number" min="0.00" max="10000.00" step="0.01">
            <lable>Description:</lable>
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
                    type_id: '5',
                    workplace_id: '',
                    model: '',
                    mark: '',
                    purchase_year: '',
                    value: '',
                    description: ''
                }
            }
        },
        methods: {
            save: function () {
                window.axios({
                    method: 'post',
                    url: '/api/accessories',
                    data: this.accessory
                }).catch(error => {
                    console.log(error.response.data)
                });
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>