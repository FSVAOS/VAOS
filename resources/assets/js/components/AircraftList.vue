<template>
    <div>
        <div class="row">
            <div class="col-lg-12 hidden-sm" style="display: inline-flex">
                <div style="width:60%">
                    <h3>Filters</h3>
                    <div style="display: flex;justify-content: space-between;">
                        <div class="form-group">
                            <label for="registrationInput">Registration</label>
                            <input v-model="filterRegistration" class="form-control" id="registrationInput">
                        </div>
                        <div class="form-group">
                            <label for="locationInput">Location</label>
                            <input class="form-control" id="locationInput">
                        </div>
                        <div class="form-group" style="margin-top: auto;">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                <label class="form-check-label" for="inlineCheckbox1">Available</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                <label class="form-check-label" for="inlineCheckbox2">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
                                <label class="form-check-label" for="inlineCheckbox3">Maintenance</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-left: auto; margin-top: auto; margin-bottom: 1rem;">
                    <h3 style="text-align: right">Actions</h3>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a v-bind:href="base_url + '/admin/' + activeAirline.id + '/fleet/create'" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Add Aircraft"><i class="fa fa-plus"></i></a>
                        <a v-bind:href="base_url + '/admin/fleet/create'" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fa fa-download"></i></a>
                        <a v-bind:href="base_url + '/admin/fleet/create'" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Upload"><i class="fa fa-upload"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div v-for="group in filterList" v-bind:key="group.id">
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" v-bind:data-target="'#'+group.id" aria-expanded="false" aria-controls="collapseTwo">
                            {{ group.name }}
                        </button>
                        <span style="float: right; margin: auto 0;line-height: 1.5;">{{ group.aircraft.length }}</span>
                    </h5>
                </div>
                <div v-bind:id="group.id" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                            <tr>
                                <th>Registration</th>
                                <th>Airline</th>
                                <th>Manufacturer</th>
                                <th>ICAO</th>
                                <th>Model</th>
                                <th>Hub</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody v-for="a in group.aircraft">
                            <aircraft-list-item v-bind:acf="a"></aircraft-list-item>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "AircraftList",
        data() {
            return {
                groups: [],
                base_url: Laravel.baseUrl,
                airline: Laravel.airline_id,
                /* Search Objects */
                filterRegistration: "",
                filterLocation: "",
                isAvailable: true,
                isActive: true,
                isDisabled: true
            }
        },
        props: {
            list_data: String
        },
        mounted() {
            this.groups = JSON.parse(this.list_data);
        },
        computed: {
            filterList: function () {
                let reg = this.filterRegistration;
                if (this.filterRegistration !== "") {
                    let output = [];
                    this.groups.forEach(function (e) {
                        let acf = e.aircraft.filter(x => x.registration.toLowerCase().includes(reg.toLowerCase()));
                        if (acf.length !== 0) {
                            output.push({
                                id: e.id,
                                name: e.name,
                                icao: e.icao,
                                aircraft: acf
                            });
                        }
                    });
                    return output;
                }
                else
                {
                    return this.groups;
                }
            },
            activeAirline () {
                return this.$store.getters.airline;
            }
        },

    }
</script>

<style scoped>

</style>