import { ref, watch } from 'vue'
import { useDebounceFn } from '@vueuse/core'
import { router } from '@inertiajs/vue3'

export default function useDataSearch(routePath, columnToSearch) {
    const searchTerm = ref()

    watch(searchTerm, (value) => {
        debouncedSearch(value)
    })

    const debouncedSearch = useDebounceFn((value) => {
        const params = {
            page: 1,
            searchContext: columnToSearch,
            searchTerm: value
        }
        fetchData(params)
    }, 500)

    const fetchData = (params) => {
        router.visit(routePath, {
            data: params,
            replace: true,
            preserveState: true
        })
    }

    const clearSearch = () => {
        searchTerm.value = ''
        const params = { page: 1 }
        fetchData(params)
    }

    return { searchTerm, fetchData, clearSearch }
}
