
export default {
    install(Vue, options){
        const vm = new Vue({
            data: {
                toolbarVisible: true,
                sidebarVisible: true,
                sidemenuVisible: false
            }
        });

        Object.defineProperties(Vue.prototype, {
            "$toolbarVisible": {
                "get": function () {
                    return vm.toolbarVisible
                },

                "set": function (value) {
                    vm.toolbarVisible = value;

                    return this
                }
            },

            "$sidebarVisible": {
                "get": function () {
                    return vm.sidebarVisible
                },

                "set": function (value) {
                    vm.sidebarVisible = value;

                    return this
                }
            },

            "$sidemenuVisible": {
                "get": function () {
                    return vm.sidemenuVisible
                },

                "set": function (value) {
                    vm.sidemenuVisible = value;

                    return this
                }
            },

            "$sideMenuTabs": {
                "get": function () {
                    return vm.sideMenuTabs
                },

                "set": function (value) {
                    vm.sideMenuTabs = value;

                    return this
                }
            }
        });

        Vue.prototype.$toggleToolbar = () => {
            Vue.prototype.$toolbarVisible = !Vue.prototype.$toolbarVisible;
        };

        Vue.prototype.$toggleSidebar = () => {
            Vue.prototype.$sidebarVisible = !Vue.prototype.$sidebarVisible;
        };

        Vue.prototype.$toggleSidemenu = () => {
            Vue.prototype.$sidemenuVisible = !Vue.prototype.$sidemenuVisible;
        };
    }
};