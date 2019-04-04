export default ({

	maximumAllowedDate (state) {

		if (state.settings !== "") {

			return state.settings.endDate;

		}

	},

});
