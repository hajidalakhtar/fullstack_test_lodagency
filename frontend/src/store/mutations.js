export function initialiseStore(state) {
    if (localStorage.getItem('store')) {
        this.replaceState(
            Object.assign(state, JSON.parse(localStorage.getItem('store')))
        );
    }
}

export function SET_USER(state, user) {
    state.user = user;
}

