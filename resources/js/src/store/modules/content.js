import $axios from '../api.js'

const state = () => ({
    // START::DATATABLE STATE
    totalDesserts: 0,
    desserts: [],
    loading: true,
    options: {},
    headers: [
        { text: 'Display', sortable: false, value: 'page_display' },
        { text: 'Status', value: 'status' },
        { text: 'Content', value: 'content' },
        { text: 'Actions', value: 'actions', sortable: false },
    ],
    // END::DATATABLE STATE

    dialog: false,
    dialogDelete: false,
    formIndex: -1,
    formItem: {
        content: 0,
        page_display: '',
        status: 0,
    },
})

const mutations = {
    SET_DATATABLES(state, payload) {
        state.totalDesserts = payload.totalDesserts,
            state.desserts = payload.desserts
    },
    SET_LOADING(state, payload) {
        state.loading = payload
    },
    SET_OPTIONS(state, payload) {
        state.options = payload
    },
    SET_DIALOG(state, payload) {
        state.dialog = payload
    },
    SET_DIALOG_DELETE(state, payload) {
        state.dialogDelete = payload
    },
    SET_FORM_INDEX(state, payload) {
        state.formIndex = payload
    },
    SET_FORM(state, payload) {
        state.formItem = {
            content: payload.content,
            page_display: payload.page_display,
            status: payload.status,
        }
    },
    CLEAR_FORM(state, payload) {
        state.formItem = {
            content: '',
            page_display: '',
            status: '',
        }
    },
}

const actions = {
    Index({ commit, state }) {
        commit('SET_LOADING', true)
        return new Promise((resolve) => {
            const { page, itemsPerPage } = state.options;
            $axios
                .get(`/content?page=${page}&perpage=${itemsPerPage}`)
                .then(function (response) {
                    if (response.status === 200 && response.data.status === "Token is Expired") {
                        setTimeout(() => {
                            localStorage.setItem('token', null)
                            commit('SET_TOKEN', null, { root: true })
                        }, 1000)
                        resolve(401)
                    } else {
                        const setdata = {
                            desserts: response.data.data,
                            totalDesserts: response.data.meta.total
                        };
                        commit('SET_DATATABLES', setdata)
                        commit('SET_LOADING', false)
                        commit('CLEAR_FORM')
                        resolve(response.status)
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        });
    },
    Show({ commit, state }) {
        return new Promise((resolve) => {
            $axios
                .get(`/content/${state.formIndex}`)
                .then(function (response) {
                    if (response.status === 200 && response.data.status === "Token is Expired") {
                        setTimeout(() => {
                            localStorage.setItem('token', null)
                            commit('SET_TOKEN', null, { root: true })
                        }, 1000)
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
    Update({ dispatch, commit, state }) {
        return new Promise((resolve) => {
            $axios
                .patch(`/content/${state.formIndex}`, state.formItem)
                .then(function (response) {
                    if (response.status === 200 && response.data.status === "Token is Expired") {
                        setTimeout(() => {
                            localStorage.setItem('token', null)
                            commit('SET_TOKEN', null, { root: true })
                        }, 1000)
                        resolve(401)
                    } else {
                        dispatch('Index')
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
    Store({ dispatch, commit, state }) {
        return new Promise((resolve) => {
            $axios
                .post(`/content`, state.formItem)
                .then(function (response) {
                    if (response.status === 200 && response.data.status === "Token is Expired") {
                        localStorage.setItem('token', null)
                        commit('SET_TOKEN', null, { root: true })
                        resolve(401)
                    } else {
                        dispatch('Index')
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
    Delete({ dispatch, commit },payload) {
        return new Promise((resolve) => {
            $axios
                .delete(`/content/${payload}`)
                .then(function (response) {
                    if (response.status === 200 && response.data.status === "Token is Expired") {
                        setTimeout(() => {
                            localStorage.setItem('token', null)
                            commit('SET_TOKEN', null, { root: true })
                        }, 1000)
                        resolve(401)
                    } else {
                        dispatch('Index')
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