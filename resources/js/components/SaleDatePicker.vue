<template>
	<div id="date-picker">
		<v-card>
			<v-card-title>
				<v-spacer></v-spacer>
				<v-icon @click="showDetailCalendar=true">calendar_today</v-icon>
			</v-card-title>
			<v-card-text>
				<v-layout row wrap>
					<v-flex>
						<v-btn icon @click.native="goToPreviousDate(date)">
							<v-icon>keyboard_arrow_left</v-icon>
						</v-btn>
					</v-flex>
					<v-flex>
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
					</v-flex>
					<v-flex>
						<v-btn icon :disabled="isNextDateAllowed" @click.native="goToNextDate(date)">
							<v-icon>keyboard_arrow_right</v-icon>
						</v-btn>
					</v-flex>
				</v-layout>
			</v-card-text>
		</v-card>
		<v-dialog
				v-model="showDetailCalendar"
				fullscreen
				hide-overlay
				persistent
		>
			<v-toolbar flat>
				<v-spacer></v-spacer>
				<v-icon @click="showDetailCalendar=false">close</v-icon>
			</v-toolbar>
			<v-calendar
					ref="calendar"
					v-model="detailCalendarBegin"

					type="month"

					:end="detailCalendarEnd"
			>
				<template v-slot:day="{ date }">
					<template v-for="sale in eventsMap[date]">
						<v-chip
								:key="sale.id"
						        v-ripple
						        color="indigo"
						        text-color="white"
								@click="showTechnicianSaleDetail(sale)"
						>
							<v-avatar>
								<img v-if="sale.technician.technician_image" alt="image" :src="`images/technicians/${sale.technician.technician_image}`">
								<v-icon v-else large>account_circle</v-icon>
							</v-avatar>
							{{ sale.technician.first_name }}
						</v-chip>
					</template>
				</template>
			</v-calendar>
		</v-dialog>
		<v-dialog
				v-model="technicianSaleDetailDialog"
				max-width="500px"
		>
				<v-card>
					<v-card-title>
						<v-layout>
							<v-flex>
								<v-avatar size="120px">
									<img v-if="saleDetail.avatar" alt="" :src="`/images/technicians/${saleDetail.avatar}`">
									<v-icon v-else large>account_circle</v-icon>
								</v-avatar>
							</v-flex>
							<v-flex>
								<span class="headline">{{ saleDetail.fullName }}</span>
							</v-flex>
						</v-layout>
					</v-card-title>
					<v-card-text>
						<v-layout row wrap>
							<v-flex>
								<span class="subheading">Sale: {{ $dollar.format(saleDetail.saleAmount) }}</span>
							</v-flex>
							<v-flex>
								<span class="subheading">Tip: {{ $dollar.format(saleDetail.tipAmount) }}</span>
							</v-flex>
						</v-layout>
					</v-card-text>
					<v-card-actions>
						<v-btn @click="technicianSaleDetailDialog=false">Close</v-btn>
					</v-card-actions>
				</v-card>
		</v-dialog>
	</div>
</template>
<script>
export default {
	name: "SaleDatePicker",
	data () {

		return {
			showCalendar: false,
			showDetailCalendar: false,
			technicianSaleDetailDialog: false,
			saleDetail: {
				fullName: "",
				saleAmount: "",
				tipAmount: "",
				avatar: "",
			}

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

		technicianSalesByPeriod () {

			return this.$store.getters["AddTechnicianSales/technicianSalesByPeriod"];

		},
		detailCalendarBegin () {

			return this.$moment(this.date).startOf("month").format("YYYY-MM-DD");

		},
		detailCalendarEnd () {

			return this.$moment(this.date).endOf("month").format("YYYY-MM-DD");

		},
		eventsMap () {

			const map = {};

			this.technicianSalesByPeriod.forEach(e => (map[e.date] = map[e.date] || []).push(e));

			return map;

		},
	},
	methods: {

		goToNextDate () {

			this.date = this.$moment(this.date).add(1, "days");

		},
		goToPreviousDate () {

			this.date = this.$moment(this.date).subtract(1, "days");

		},
		showTechnicianSaleDetail (sale) {

			this.saleDetail.fullName = sale.technician.full_name;
			this.saleDetail.saleAmount = sale.sale_amount;
			this.saleDetail.tipAmount = sale.tip_amount;
			this.saleDetail.avatar = sale.technician.technician_image;
			this.technicianSaleDetailDialog = true;

		},
	},
};
</script>

<style scoped>
	.sales {
		color: white;
		background-color: blue;
		padding: 3px;
		margin-bottom: 1px;
		border-radius: 2px;
		font-size: 14px;
		cursor: pointer;
	}
</style>
