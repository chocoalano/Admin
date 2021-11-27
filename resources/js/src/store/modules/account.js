import $axios from '../api.js'

const state = () => ({
    formAccountUpdate: {
        name: '',
        email: '',
    },
    formAccountPass: {
        current_password: '',
        new_password: '',
        new_confirm_password: '',
    },
})

const mutations = {
    SET_FORM_ACCOUNT(state, payload) {
        state.formAccountUpdate = {
            name: payload.name,
            email: payload.email,
        }
    },
    CLEAR_FORM_ACCOUNT(state, payload) {
        state.formAccountUpdate = {
            name: '',
            email: '',
        }
    },
    SET_FORM_ACCOUNT_PASS(state, payload) {
        state.formAccountPass = {
            current_password: payload.current_password,
            new_password: payload.new_password,
            new_confirm_password: payload.new_confirm_password,
        }
    },
    CLEAR_FORM_ACCOUNT_PASS(state, payload) {
        state.formAccountPass = {
            current_password: '',
            new_password: '',
            new_confirm_password: '',
        }
    },
}

const actions = {
    getAccount({ commit, state }) {
        return new Promise((resolve) => {
            $axios
                .get(`/auth`)
                .then(function (response) {
                    if (response.status === 200 && response.data.status === "Token is Expired") {
                        localStorage.setItem('token', null)
                        commit('SET_TOKEN', null, { root: true })
                        resolve(401)
                    } else {
                        resolve(response)
                    }
                })
                .catch(function (error) {
                    commit('SET_ERRORS', error.response.data.message, { root: true })
                    setTimeout(() => {
                        commit('SET_ERRORS', [], { root: true })
                    }, 1000)
                });
        });
    },
    UpdateAccount({ commit, state }) {
        return new Promise((resolve) => {
            $axios
                .post(`/update-account`, state.formAccountUpdate)
                .then(function (response) {
                    if (response.status === 200 && response.data.status === "Token is Expired") {
                        localStorage.setItem('token', null)
                        commit('SET_TOKEN', null, { root: true })
                        resolve(401)
                    } else {
                        resolve(response)
                    }
                })
                .catch(function (error) {
                    commit('SET_ERRORS', error.response.data.message, { root: true })
                    setTimeout(() => {
                        commit('SET_ERRORS', [], { root: true })
                    }, 1000)
                });
        });
    },
    UpdatePassword({ commit, state }) {
        return new Promise((resolve) => {
            $axios
                .post(`/update-account-pass`, state.formAccountPass)
                .then(function (response) {
                    if (response.status === 200 && response.data.status === "Token is Expired") {
                        localStorage.setItem('token', null)
                        commit('SET_TOKEN', null, { root: true })
                        resolve(401)
                    } else {
                        resolve(response)
                    }
                })
                .catch(function (error) {
                    commit('SET_ERRORS', error.response.data.message, { root: true })
                    setTimeout(() => {
                        commit('SET_ERRORS', [], { root: true })
                    }, 1000)
                });
        });
    },
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}