<template>
    <div class="container">
        <div class="alert-success" v-if="success != false">{{ success }}</div>
        <p v-if="editing">Edit existing type.</p>
        <p v-else>Create new accessory type.</p>
        <form v-on:submit.prevent="save()">
            <div class="form-group">
                <label>Type name:</label>
                <input v-model="type.name" type="text">
                <p class="alert-danger" v-if="errors.name">{{ errors.name.join(' ') }}</p>
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
                type: {
                    name: ''
                },
                errors: false,
                success: false,
                editing: false,
                editTypeId: ''
            }
        },
        methods: {
            save: function () {
                var method = this.editing ? 'put' : 'post';
                var url = this.editing ? '/api/types/' + this.editTypeId : '/api/types';
                window.axios({
                    method: method,
                    url: url,
                    data: this.type
                }).then(response => {
                    if(response.status === 201 || response.status === 200) {
                        this.success = response.status === 200 ? "Save edited type." : "Added new Type";
                        this.clearComponent();
                        setTimeout(() => {
                            this.success = false;
                        }, 3000);

                        Event.$emit('refreshTypesTable')
                    }
                }).catch(error => {
                    this.errors = error.response.data.errors;
                })
            },
            setEditingType: function (editTypeId) {
                window.axios({
                    method: 'get',
                    url: 'api/types/' + editTypeId
                }).then(response => {
                    this.editing = true;
                    this.type.name = response.data.name;
                    this.editTypeId = editTypeId;
                });
            },
            clearComponent: function () {
                this.errors = false
                this.type = {
                    name: ''
                };
                this.editing = false;
                this.editTypeId = ''
            }
        },
        mounted() {
            console.log('Component mounted.')

            Event.$on('editType', (editTypeId) => {
                this.setEditingType(editTypeId);
            })
            Event.$on('clearAddEditComponent', () =>{
                this.clearComponent();
            })
        }
    }
</script>