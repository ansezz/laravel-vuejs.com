import Vue from 'vue';
import InfiniteLoading from 'vue-infinite-loading';
import Spinner from '@/components/shared/partials/elements/Spinner';

Vue.use(InfiniteLoading, {
    slots: {
        spinner: Spinner,
    },
});