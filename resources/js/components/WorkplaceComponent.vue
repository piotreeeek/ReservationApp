<template>
    <div class="container">
        <div class="alert-success" v-if="success != false">{{ success }}</div>
        <p v-if="editing">Edit existing workplace.</p>
        <p v-else>Create new workplace.</p>
        <form v-on:submit.prevent="save()">
            <div class="form-group">
                <label>Mark:</label>
                <input v-model="workplace.mark" type="text">
                <p class="alert-danger" v-if="errors.mark">{{ errors.mark.join(' ') }}</p>
            </div>
            <div class="form-group">
                <label>Description:</label>
                <textarea v-model="workplace.description"></textarea>
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
                workplace: {
                    mark: '',
                    description: ''
                },
                errors: false,
                success: false,
                editing: false,
                editWorkplaceId: ''
            }
        },
        methods: {
            save: function () {
                var method = this.editing ? 'put' : 'post';
                var url = this.editing ? '/api/workplaces/' + this.editWorkplaceId : '/api/workplaces';
                window.axios({
                    method: method,
                    url: url,
                    data: this.workplace
                }).then(response => {
                    console.log(response)
                    if(response.status === 201 || response.status === 200) {
                        this.success = response.status === 200 ? "Save edited workplace." : "Added new workplace";
                        this.clearComponent();
                        setTimeout(() => {
                            this.success = false;
                        }, 3000);

                        Event.$emit('refreshWorkplacesTable')
                    }
                }).catch(error => {
                    console.log(error.response.data)
                    this.errors = error.response.data.errors;
                });
            },
            setEditingWorkplace: function (editWorkplaceId) {
                window.axios({
                    method: 'get',
                    url: 'api/workplaces/' + editWorkplaceId
                }).then(response => {
                    console.log(response.data)
                    this.editing = true;
                    this.workplace = {
                        mark: response.data.mark,
                        description: response.data.description
                    }
                    this.editWorkplaceId = editWorkplaceId
                }).catch(error => {
                    console.log(error.response)
                })
            },
            clearComponent: function () {
                this.errors = false
                this.workplace = {
                    mark: '',
                    description: ''
                }
                this.editing = false;
                this.editWorkplaceId = ''
            }
        },
        mounted() {
            console.log('Component mounted.')

            Event.$on('editWorkplace', (editWorkplaceId) => {
                this.setEditingWorkplace(editWorkplaceId);
            })
            Event.$on('clearAddEditComponent', () =>{
                this.clearComponent();
            })
        }
    }
</script>