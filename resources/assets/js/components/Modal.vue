<template>
    <transition name="modal">
    <div class="modal-mask" v-show="show">
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
    </transition>
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

<style lang="scss" type="text/scss">
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100%;
        background-color: rgba(0, 0, 0, .9);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 100%;
        max-width: 600px;
        margin: 0px auto;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
        padding: 0;
        max-height: 100vh;
        overflow-y: auto;

        &.wide {
            max-width: 900px;
        }
    }

    .modal-header h3 {
        margin-top: 0;
        color: dodgerblue;
        max-height: 80px;
    }

    .modal-body {
        /*max-height: calc(85vh - 180px);*/
        overflow-y: auto;
    }

    .modal-footer {
        max-height: 100px;
    }

    .modal-default-button {
        background: dodgerblue;
        color: white;
    }

    .modal-enter, .modal-leave {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>