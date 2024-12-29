<?php


use App\Models\Permission;

if (!function_exists('convertPermissionsToString')) {
    /**
     * Convert permissions from array to string comma separated.
     *
     * @param array $permissions
     * @return string
     */
    function convertPermissionsToString(array $permissions)
    {
        $string = '';
        $string = implode(', ', $permissions);

        return  $string;
    }
}

if (!function_exists('convertPermissionsToArray')) {
    /**
     * Convert permissions from comma separated string to array
     * @return string
     * @param array $permissions
     */
    function convertPermissionsToArray(string $permissions, string $returnColumn = 'id'):array
    {
        $permissions = explode(',', $permissions);
        foreach ($permissions as &$permission){
            $permission = trim($permission);
        }

        if($returnColumn == 'id'){
            $permissions = Permission::whereIn('name', $permissions)->pluck('id')->toArray();
        }

        if($returnColumn == 'name'){
            $permissions = Permission::whereIn('name', $permissions)->pluck('name')->toArray();
        }

        return $permissions;
    }
}

if (!function_exists('getAllowedImportTypes')) {
    /**
     * Convert permissions from comma separated string to array
     * @return array
     * @param array $permissions
     * @param array $importTypes
     */
    function getAllowedImportTypes(array $permissions, array $importTypes):array
    {
        foreach ($importTypes as $key => $type) {
            if(!in_array($type['permission_required'], $permissions)) {
                unset($importTypes[$key]);
            }
        }
        return $importTypes;
    }
}
