<x-layout>
    <div class="d-flex justify-content-between align-items-center py-5">
        <h1 class="text-center d-inline">Upload Files</h1>
    </div>
    <div class="col-sm-6 col-sm-offset-3">
        <form action="{{route('imports.upload')}}" method="POST" enctype='multipart/form-data'>
            @csrf

            <x-inputs.select
                :options="$importTypes"
                name="importType"
                label="Import Type"
            />
            <div id="dynamic-file-inputs"></div>
            <button type="submit" class="btn btn-block btn-primary">Submit</button>
        </form>
    </div>

    <script>
        const importTypes = @json($importTypes);
        const importTypeSelect = document.getElementById('importType');
        const dynamicFileInputsContainer = document.getElementById('dynamic-file-inputs');
        function updateFileInputs() {
            dynamicFileInputsContainer.innerHTML = '';
            const importTypeSelectValue = importTypeSelect.value;
            const filesByImportType = importTypes[importTypeSelectValue]['files']
            Object.entries(filesByImportType).forEach(([key, config]) => {
                const inputWrapper = document.createElement('div');
                const fileName = importTypeSelectValue + '_' + key;
                inputWrapper.innerHTML = `<x-inputs.file id='${key}' name='${fileName}[]' label='${config.label}' helpText='${config.requiredHeadersText}'/>`;
                dynamicFileInputsContainer.appendChild(inputWrapper)
            });
        }
        document.addEventListener('DOMContentLoaded', updateFileInputs);
        importTypeSelect.addEventListener('change', updateFileInputs);
    </script>
</x-layout>
