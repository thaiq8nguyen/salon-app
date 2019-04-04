<template>
	<div id="date-picker">
		<v-card>
			<v-card-title class="justify-space-between">
				<v-btn icon @click.native="goToPreviousDate(date)">
					<v-icon>keyboard_arrow_left</v-icon>
				</v-btn>
				<v-menu
						v-model="showCalendar"
						lazy
						:close-on-content-click="true"
						transition="scale-transition"
						offset-y
						full-width
						:nudge-left="0"
						max-width="290px"
				>
					<v-text-field
							slot="activator"
							label="Select a sale date"
							:value="formattedDate"
							readonly
					></v-text-field>
					<v-date-picker
							v-model="date"
							no-title
							scrollable
							actions
							:max="maximumAllowedDate"
					>
					</v-date-picker>
				</v-menu>
				<v-btn icon :disabled="isNextDateAllowed" @click.native="goToNextDate(date)">
					<v-icon>keyboard_arrow_right</v-icon>
				</v-btn>
			</v-card-title>
		</v-card>
	</div>
</template>
<script>
export default {
	name: "SaleDatePicker",
	data () {

		return {
			showCalendar: false,
		};

	},
	computed: {
		date: {

			get () {

				return this.$store.getters["date"];

			},
			set (date) {

				this.$store.dispatch("setDate", date);

			}
		},
		formattedDate () {

			return this.$store.getters["dateTextField"];

		},
		/* mininumAllowedDate () {

			return this.$store.getters["PayPeriods/beginDate"];

		}, */
		maximumAllowedDate () {

			return this.$store.getters["AppSettings/maximumAllowedDate"];

		},
		isNextDateAllowed () {

			return this.date >= this.maximumAllowedDate;

		},

		/* isPreviousDateAllowed () {

			return this.date <= this.mininumAllowedDate;

		}, */
	},
	methods: {

		goToNextDate () {

			this.date = this.$moment(this.date).add(1, "days");

		},
		goToPreviousDate () {

			this.date = this.$moment(this.date).subtract(1, "days");

		},
	},
};
</script>

<style scoped>

</style>
