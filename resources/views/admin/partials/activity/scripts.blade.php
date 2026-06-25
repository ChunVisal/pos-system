<script>
    function activityPage() {
        return {
            modalOpen: false,
            selectedActivity: {},

            refreshLogs() {
                console.log('Refreshing logs...');
                // Implement refresh logic
            },

            viewActivity(activity) {
                this.selectedActivity = activity;
                this.modalOpen = true;
            },

            viewChanges(log) {
                console.log('Viewing changes for:', log);
                // Implement view changes logic
            },

            closeModal() {
                this.modalOpen = false;
            }
        }
    }
</script>

<style>
    [x-cloak] {
        display: none !important;
    }

    /* Custom scrollbar for tabs */
    .activity-tab-container::-webkit-scrollbar {
        height: 3px;
    }

    .activity-tab-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .dark .activity-tab-container::-webkit-scrollbar-track {
        background: #27272a;
    }

    .activity-tab-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .dark .activity-tab-container::-webkit-scrollbar-thumb {
        background: #52525b;
    }

    .activity-tab-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .dark .activity-tab-container::-webkit-scrollbar-thumb:hover {
        background: #71717a;
    }
</style>
