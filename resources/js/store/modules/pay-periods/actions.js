import PayPeriodServices from "Services/pay-period-services";

export default {

	getCurrent () {

		return new Promise((resolve, reject) => {

			return PayPeriodServices.getCurrent()
				.then(response => {

					resolve(response.data.payPeriods);

				})
				.catch(errors => {

					reject(errors);

				});

		});

	}

};
