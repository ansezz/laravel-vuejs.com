import {main_menu, second_menu, social_media} from '@/config'

export const state = () => ({
    platform: "",
    navigation: {
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
    }
}

export const getters = {}

export const actions = {
    toggleNavigationVisibility({commit, state}) {
        commit("SET_NAVIGATION_VISIBILITY", !state.navigation.visibility)
    }
}
