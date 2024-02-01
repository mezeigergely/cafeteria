<script setup>
import { onMounted, ref } from 'vue'
import CalculateButton from './buttons/Calculate.vue'
import ResetButton from './buttons/Reset.vue'
import XmlButton from './buttons/Xml.vue'
import SaveButton from './buttons/Save.vue'
import Table from './Table.vue'

const initialBudget = ref([])
let remainderBudget = ref([])
const currency = ref([])
const pocketBudgetLimit = ref([])
let pockets = ref([])
let pocketValues = ref({})
let pocketValuesArray = ref({})
let proxyObject = ref({})
let values = ref([])
let next = false
let months = ref([])

let form = ref([])

onMounted(async () => {
    getPlanData()
})

const onNext = async () => {
    let result = 0
    proxyObject.value = pocketValues.value
    const keys = Object.keys(proxyObject.value)
    for (const key of keys) {
        values[key] = proxyObject.value[key]
        result = result + values[key]
    }

    const tempPocketValuesArray = Object.values(pocketValues.value)
    pocketValuesArray = tempPocketValuesArray.map(value => (value / 12).toFixed(2));

    remainderBudget.value = initialBudget.value - result
    next = true

    const formData = new FormData();
    formData.append('pockets_budget_annual',tempPocketValuesArray)
    formData.append('pockets_budget_monthly',pocketValuesArray)
    let response = await axios.post('/save',formData)
}

const getPlanData = async () => {
    let response = await axios.get('/get_plan_data')
    initialBudget.value = response.data.budget
    remainderBudget.value = initialBudget.value
    currency.value = response.data.currency
    pockets.value = response.data.pockets
    pocketBudgetLimit.value = response.data.pocketBudgetLimit
    months.value = response.data.months
}
</script>

<template>
    <div>
        <div class="d-flex justify-content-center mb-4">
            <span id="cafeteriaBudget">{{ remainderBudget }}</span>
            <span id="currency">{{ currency }}</span>
        </div>
        <form @submit.prevent="onNext()" class="content">
            <div class="row mb-4">
                <div class="col"></div>
                <div class="col" v-for="(value, key) in pockets" :key="key">
                    <div class="d-flex justify-content-center mb-2">{{ value }}</div>
                    <div class="input-group mb-2">
                        <input
                            type="number" class="form-control"
                            v-model="pocketValues[(key + 1)]"
                            min=0
                            required>
                        <span class="input-group-text" id="currency">{{ currency }}</span>
                    </div>
                    <div class="d-flex justify-content-center mb-2">
                        <span>limit: </span>
                        <span id="pocketBudgetLimit">{{ pocketBudgetLimit }}</span>
                        <span id="currency">{{ currency }}</span>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mb-4">
                <CalculateButton />
            </div>
        </form>
                           
        <div v-if="next">
            <div class="d-flex justify-content-center mb-4">
                <ResetButton />
                <XmlButton />
                <SaveButton />
            </div>
            <div class="d-flex justify-content-center mb-4">
                <Table :pockets="pockets" :months="months" :pocketValues="pocketValuesArray" />
            </div>
            
        </div>
    </div>
</template>

