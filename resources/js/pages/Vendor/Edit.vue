import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import UpdateVendorForm from './Partials/UpdateVendorForm';

export default function Edit({ vendor,edit }) {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Vendor Edit
                </h2>
            }
        >
            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                        <UpdateVendorForm 
                         vendor={vendor}
                         edit={edit}
                        className="max-w-xl" />
                    </div>

                    {/* <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                                   <DeleteUserForm className="max-w-xl" />
                               </div> */}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
