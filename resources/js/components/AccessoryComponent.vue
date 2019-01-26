<template>
    <div class="container">
        <div class="alert-success" v-if="success != false">{{ success }}</div>
        <p v-if="editing">Edit existing accessory.</p>
        <p v-else>Create new accessory.</p>
        <form v-on:submit.prevent="save()">
            <div class="form-group">
                <label>Model:</label>
                <input v-model="accessory.model" type="text">
                <p class="alert-danger" v-if="errors.model">{{ errors.model.join(' ') }}</p>

            </div>
            <div class="form-group">
                <label>Type:</label>
                <select v-model="accessory.type_id">
                    <option v-for="type in types" :value="type.id">{{ type.name }}</option>
                </select>
                <p class="alert-danger" v-if="errors.type_id">{{ errors.type_id.join(' ') }}</p>
            </div>
            <div class="form-group">
                <label>Workplace:</label>
                <select v-model="accessory.workplace_id">
                    <option v-for="workplace in workplaces" :value="workplace.id">{{ workplace.mark}}</option>
                </select>
                <p class="alert-danger" v-if="errors.workplace_id">{{ errors.workplace_id.join(' ') }}</p>
            </div>
            <div class="form-group">
                <label>Mark:</label>
                <input v-model="accessory.mark" type="text">
                <p class="alert-danger" v-if="errors.mark">{{ errors.mark.join(' ') }}</p>
            </div>
            <div class="form-group">
                <label>Purchase year:</label>
                <input v-model="accessory.purchase_year" type="number" min="1900" :max="current_year" step="1">
                <p class="alert-danger" v-if="errors.purchase_year">{{ errors.purchase_year.join(' ') }}</p>
            </div>
            <div class="form-group">
                <label>Value:</label>
                <input v-model="accessory.value" type="number" min="0.00" max="10000.00" step="0.01">
                <p class="alert-danger" v-if="errors.value">{{ errors.value.join(' ') }}</p>
            </div>
            <div class="form-group">
                <label>Description:</label>
                <textarea v-model="accessory.description"></textarea>
                <p class="alert-danger" v-if="errors.description">{{ errors.description.join(' ') }}</p>
            </div>
            <button class="btn" v-if="editing">Save</button>
            <button class="btn" v-else>Add</button>
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
                errors: false,
                success: false,
                current_year: (new Date()).getFullYear(),
                editing: false,
                editAccessoryId: ''
            }
        },
        methods: {
            save: function () {
                var method = this.editing ? 'put' : 'post';
                var url = this.editing ? '/api/accessories/' + this.editAccessoryId : '/api/accessories';
                window.axios({
                    method: method,
                    url: url,
                    data: this.accessory
                }).then(response => {
                    console.log(response)
                    if(response.status === 201 || response.status === 200) {
                        this.success = response.status === 200 ? "Save edited accessory." : "Added new accessory";
                        this.clearComponent();
                        setTimeout(() => {
                            this.success = false;
                        }, 3000);

                        Event.$emit('refreshAccessoriesTable')
                    }
                }).catch(error => {
                    console.log(error.response.data)
                    this.errors = error.response.data.errors;
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
            setEditingAccessory: function (editAccessoryId) {
                window.axios({
                    method: 'get',
                    url: 'api/accessories/' + editAccessoryId
                }).then(response => {
                    console.log(response.data)
                    this.editing = true;
                    this.accessory = {
                        type_id: response.data.type_id,
                        workplace_id: response.data.workplace_id,
                        model: response.data.model,
                        mark: response.data.mark,
                        purchase_year: response.data.purchase_year,
                        value: response.data.value,
                        description: response.data.description
                    }
                    this.editAccessoryId = editAccessoryId
                }).catch(error => {
                    console.log(error.response)
                })
            },
            clearComponent: function () {
                this.errors = false
                this.accessory = {
                    type_id: '',
                    workplace_id: '',
                    model: '',
                    mark: '',
                    purchase_year: '',
                    value: '',
                    description: ''
                };
                this.editing = false;
                this.editAccessoryId = ''
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.fetchWorkplaces()
            this.fetchTypes()

            Event.$on('editAccessory', (editAccessoryId) => {
                this.setEditingAccessory(editAccessoryId);
            })
            Event.$on('clearAddEditComponent', () =>{
                this.clearComponent();
            })
        }
    }
</script>