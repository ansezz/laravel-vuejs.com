Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'wp-importer',
            path: '/wp-importer',
            component: require('./components/Tool'),
        },
    ])
})
