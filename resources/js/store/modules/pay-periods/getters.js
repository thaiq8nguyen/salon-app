export default {

	current (state) {

		return state.currentPayPeriod;

	},
	beginDate (state) {

		return state.currentPayPeriod.begin_date;

	},


};
