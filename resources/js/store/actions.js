export default {

	async init ({ commit, dispatch }) {

		const technicians = await dispatch("Technicians/getTechnicians", null, { root: true });
		commit("Technicians/SET_TECHNICIANS", technicians, { root: true });

	},
	setDate ({ commit }, date) {

		commit("SET_DATE", date);

	},

};
