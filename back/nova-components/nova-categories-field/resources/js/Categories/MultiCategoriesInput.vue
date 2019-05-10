<template>
    <categories-input
      :categories="categories"
      :type="type"
      :suggestion-limit="suggestionLimit"
      @input="handleInput"
    >
        <div slot-scope="{ categories, removeCategory, inputProps, inputEvents, suggestions, insertSuggestion }">
            <div class="categories-input w-full form-control form-input form-input-bordered flex items-center" @click="focusInput">
                <span v-for="category in categories" :key="category" class="categories-input-category mr-1">
                    <span>{{ category }}</span>
                    <button
                        type="button"
                        class="categories-input-remove"
                        @click.prevent.stop="removeCategory(category)"
                    >
                        &times;
                    </button>
                </span>
                <input
                    ref="input"
                    class="categories-input-text"
                    :placeholder="__('Add category...')"
                    v-bind="inputProps"
                    v-on="inputEvents"
                >
            </div>
            <ul v-if="suggestions.length" class="categories-input-suggestions">
                <li v-for="suggestion in suggestions" :key="suggestion" class="mr-1">
                    <button
                        class="categories-input-category"
                        @mousedown.prevent
                        @click.prevent="insertSuggestion(suggestion)"
                    >
                        {{ suggestion }}
                    </button>
                </li>
            </ul>
        </div>
    </categories-input>
</template>

<script>
import CategoriesInput from './CategoriesInput.vue';

export default {
    props: ['categories', 'type', 'suggestionLimit'],

    model: {
        prop: 'categories',
    },

    components: {
        CategoriesInput,
    },

    methods: {
        focusInput() {
            this.$refs.input.focus();
        },

        handleInput(categories) {
            this.$emit('input', categories);

            // Re-focus the input after a suggestion was inserted
            this.focusInput();
        },
    },
};
</script>
