<style>

</style>

<template>
    <div class="modal-mask" v-show="show" transition="modal">
        <div class="modal-wrapper">
            <div class="modal-container" :class="{'wide': wider}">

                <div class="modal-header">
                    <slot name="header">
                        default header
                    </slot>
                </div>

                <div class="modal-body">
                    <slot name="body">
                        default body
                    </slot>
                </div>

                <div class="modal-footer">
                    <slot name="footer">
                        <button class="modal-default-button"
                                @click="show = false">
                            OK
                        </button>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        props: {
            show: {
                type: Boolean,
                required: true,
                twoWay: true
            },

            wider: {
                type: Boolean,
                required: false,
                default: false
            }
        }
    }
</script>