<template>
    <nuxt-link :to="routeName" class="article-image" v-lazy-container="{ selector: 'img' }">
        <img v-if="src" :data-src="src" :alt="alt">
        <span class="post-loader">
            <span class="sk-cube1 sk-cube"></span>
            <span class="sk-cube2 sk-cube"></span>
            <span class="sk-cube4 sk-cube"></span>
            <span class="sk-cube3 sk-cube"></span>
        </span>
        <span class="post-error"></span>
    </nuxt-link>
</template>

<script>
    export default {
        name: "Thumbnail",
        props: {
            routeName: {
                type: String,
                default: "/"
            },
            paramValue: {
                type: String,
                default: null
            },
            src: {
                type: String,
                default: null
            },
            alt: {
                type: String,
                default: null
            }
        }
    }

</script>

<style lang="stylus" scoped>
    .post-loader {
        position: absolute;
        width: 30px;
        height: 30px;
        transform: rotateZ(45deg);
        transition: opacity .25s ease-in-out;

        .sk-cube {
            float: left;
            width: 50%;
            height: 50%;
            position: relative;
            transform: scale(1.1);

            &:before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(56,68,87,0.5);
                animation: sk-foldCubeAngle 2.4s infinite linear both;
                transform-origin: 100% 100%;
            }

            &.sk-cube2 {
                transform: scale(1.1) rotateZ(90deg);

                &:before {
                    animation-delay: 0.3s;
                }
            }

            &.sk-cube3 {
                transform: scale(1.1) rotateZ(180deg);

                &:before {
                    animation-delay: 0.6s;
                }
            }

            &.sk-cube4 {
                transform: scale(1.1) rotateZ(270deg);

                &:before {
                    animation-delay: 0.9s;
                }
            }
        }
    }

    @keyframes sk-foldCubeAngle {

        0%,
        10% {
            -webkit-transform: perspective(140px) rotateX(-180deg);
            transform: perspective(140px) rotateX(-180deg);
            opacity: 0;
        }

        25%,
        75% {
            -webkit-transform: perspective(140px) rotateX(0deg);
            transform: perspective(140px) rotateX(0deg);
            opacity: 1;
        }

        90%,
        100% {
            -webkit-transform: perspective(140px) rotateY(180deg);
            transform: perspective(140px) rotateY(180deg);
            opacity: 0;
        }
    }

    .post-error {
        position: absolute;
        opacity: 0;
        color: #FFF;
        font-size: 14px;
        transition: opacity .25s ease-in-out;

        &:before {
            content: "";
            display: block;
            margin: auto;
            background-image: url("../../../../assets/images/broken-pic.png");
            background-size: contain;
            width: 40px;
            height: 40px;
        }
    }

    .article-image {
        display: flex;
        justify-content: center;
        align-items: center;
        background-size: 50%;
        position: relative;
        overflow: hidden;
        padding: 0;
        width: 100%;
        background-color: rgba($tertiary, .05);
        height: 136px;
        img {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity .25s ease-in-out,
                transform .5s ease-in-out;

            &[lazy=error] {
                opacity: 0;

                ~.post-loader {
                    opacity: 0;
                }

                ~.post-error {
                    opacity: 1;
                }
            }

            &[lazy=loading] {
                opacity: 0;

                ~.post-loader {
                    opacity: 1;
                }
            }

            &[lazy=loaded] {
                opacity: 1;

                ~.post-loader {
                    opacity: 0;
                }
            }
        }

        &.small {
            img {
                &[lazy=error] {
                    ~.post-error {
                        font-size: 10px;

                        &:before {
                            width: 25px;
                            height: 25px;
                        }
                    }
                }
            }
        }
    }

</style>
