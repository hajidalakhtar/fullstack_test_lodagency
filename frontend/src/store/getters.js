export function isAuthenticated(state) {
    return !!state.user;
}

export function getUser(state) {
    return state.user;
}
