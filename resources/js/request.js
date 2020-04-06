import store from "./store";

export function getRequest(url, loading = false, rootUrl = false, csrf = false) {
    return new Promise((resolve, reject) => {
        if (loading) {
            store.state.dataLoading = true;
            var loader = webToast.loading({
                status: 'Loading...',
                message: 'Please Wait a moment',
                line: true
            });
        }

        let baseURL = '';
        if (rootUrl) {
            baseURL = corsData.root + 'PluginMaster/v1/';
        }

        let options = {
            method: 'get',
        };

        if (csrf) {
            options.headers = new Headers({'X-WP-Nonce': corsData.security})
        }

        fetch(baseURL + url, options).then(function (response) {
            if (loading) {
                store.state.dataLoading = false;
                loader.fadeOut().remove()
            }

            if (response.status === 200) {

                resolve(response.json());

            } else {

                resolve(false);

            }

        });
    });
}


export function postRequest(url, data, loading = false) {
    return new Promise((resolve, reject) => {
        if (loading) {
            store.state.dataLoading = true;
            var loader = webToast.loading({
                status: 'Loading...',
                message: 'Please Wait a moment',
                line: true
            });
        }
        const options = {
            headers: {
                'X-WP-Nonce': corsData.security,
            },
            method: 'post',
            body: JSON.stringify(data)
        };

        fetch(corsData.root + 'PluginMaster/v1/' + url, options)
            .then(response => {
                    let responseData =  response.json() ;
                    if(response.status === 200){
                        webToast.Success({
                            status: "Success",
                            "message" : response.message ? response.message : "Successfully Completed",
                        })
                        resolve(response);
                        return {status: 200}
                    }

               return responseData

            })
            .then((response) => {
                if(response.status !== 200){
                    webToast.Danger({
                        status: 'Sorry !',
                        message: response.message ? response.message : "Something went wrong",
                    });
                    resolve(false);
                }

                if (loading) {
                    store.state.dataLoading = false;
                    loader.fadeOut().remove()
                }

            }) ;

    });
}

