Nova.booting((Vue, router) => {
    Vue.config.devtools = true;
    Vue.component('index-nova-categories-field', require('./components/IndexField'));
    Vue.component('detail-nova-categories-field', require('./components/DetailField'));
    Vue.component('form-nova-categories-field', require('./components/FormField'));
})
