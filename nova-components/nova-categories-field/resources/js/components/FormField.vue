<template>
    <default-field :field="field">
        <template slot="field">
            <component
                :is="component"
                :name="field.name"
                :type="field.type"
                :suggestion-limit="field.suggestionLimit"
                v-model="categories"
            ></component>
        </template>
    </default-field>
</template>

<script>
    import MultiCategoriesInput from '../Categories/MultiCategoriesInput';
    import SingleCategoriesInput from '../Categories/SingleCategoriesInput';
    import { FormField, HandlesValidationErrors } from 'laravel-nova';

    export default {
        inheritAttrs: false,

        mixins: [FormField, HandlesValidationErrors],

        props: ['field'],

        data() {
            return {
                categories: this.field.value,
            };
        },

        components: {
            MultiCategoriesInput,
            SingleCategoriesInput,
        },

        computed: {
            component() {
                return this.field.multiple ? 'multi-categories-input' : 'single-categories-input';
            },
        },

        methods: {
            fill(formData) {
                formData.append(this.field.attribute, this.categories.join('-----'));
            },

            handleChange(value) {
                this.value = value;
            },
        },
    };
</script>
