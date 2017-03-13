<style></style>

<template>
    <span class="toggle-switch-component">
        <input type="checkbox" :id="`gg-toggle-switch${uniqueId}`" v-model="is_checked" @change="onChange">
        <label :for="`gg-toggle-switch${uniqueId}`">
            <div class="switch-holder">
                <span class="text-label checked-label" v-text="checkedLabel"></span>
                <span class="text-label unchecked-label" v-text=uncheckedLabel></span>
                <div class="switch-cover"></div>
            </div>
        </label>
    </span>
</template>

<script type="text/babel">
    export default {
        props: {
            'initial-status': {
                type: Boolean,
                required: false,
                default: false
            },

            'unique-id': {
                type: String,
                required: false,
                default: '1'
            },

            'checked-label': {
                type: String,
                required: false,
                default: 'Yes'
            },

            'unchecked-label': {
                type: String,
                required: false,
                default: 'No'
            },
        },

        data() {
            return {
                is_checked: null
            };
        },

        mounted() {
            console.log(this.initialStatus);
            this.is_checked = this.initialStatus;
        },

        methods: {
            onChange() {
                this.$emit('switch-toggled', {state: this.is_checked});
            }
        }
    }
</script>