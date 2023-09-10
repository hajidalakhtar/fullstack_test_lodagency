import axiosClient from "@/axiosClient";

export function login({commit}, {email, password}) {
    let loginData = new FormData();
    loginData.append('username', email);
    loginData.append('password', password);
    axiosClient
        .post('login', loginData)
        .then(({data}) => {
            console.log(data)
            commit('SET_USER', data);
        })
        .catch(err => {
            console.error(err);
        });
}

