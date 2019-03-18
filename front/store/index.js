import {main_menu, second_menu, social_media} from '@/config'

export const state = () => ({
    platform: "",
    navigation: {
        visibility: false
    },
    search: {
        visibility: false
    },
    social_media,
    main_menu,
    second_menu
})

export const mutations = {
    SET_PLATFORM: (state, {platform}) => {
        state.platform = platform
    },
    SET_NAVIGATION_VISIBILITY: (state, val) => {
        state.navigation.visibility = val
    },
    SET_SEARCH_VISIBILITY: (state, val) => {
        state.search.visibility = val
        state.search.visibility ? document.querySelector('html').classList.add('no-scroll') : document.querySelector('html').classList.remove('no-scroll')
    }
}

export const getters = {}

export const actions = {
    toggleNavigationVisibility({commit, state}) {
        commit("SET_NAVIGATION_VISIBILITY", !state.navigation.visibility)
    },
    toggleSearchVisibility({commit, state}) {
        commit("SET_SEARCH_VISIBILITY", !state.search.visibility)
    }
}
