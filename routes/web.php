<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\EmpresaController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('empresas', [EmpresaController::class, 'index'])->name('empresas.index');
    Route::get('empresas/create', [EmpresaController::class, 'create'])->name('empresas.create');
    Route::post('empresas', [EmpresaController::class, 'store'])->name('empresas.store');
    Route::get('empresas/{empresa}', [EmpresaController::class, 'show'])->name('empresas.show');
    Route::get('empresas/{empresa}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');
    Route::put('empresas/{empresa}', [EmpresaController::class, 'update'])->name('empresas.update');
    Route::delete('empresas/{empresa}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');
    Route::patch('empresas/{empresa}/toggle', [EmpresaController::class, 'toggle'])->name('empresas.toggle');
});

//DOCTOR
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/doctores', [App\Http\Controllers\DoctorController::class, 'index'])->name('admin.doctores.index');
    Route::get('/admin/doctores/inactivos', [App\Http\Controllers\DoctorController::class, 'inactivos'])->name('admin.doctores.inactivos');
    Route::get('/admin/doctores/create', [App\Http\Controllers\DoctorController::class, 'create'])->name('admin.doctores.create');
    Route::post('/admin/doctores', [App\Http\Controllers\DoctorController::class, 'store'])->name('admin.doctores.store');
    Route::get('/admin/doctores/{doctor}', [App\Http\Controllers\DoctorController::class, 'show'])->name('admin.doctores.show');
    Route::get('/admin/doctores/{doctor}/edit', [App\Http\Controllers\DoctorController::class, 'edit'])->name('admin.doctores.edit');
    Route::put('/admin/doctores/{doctor}', [App\Http\Controllers\DoctorController::class, 'update'])->name('admin.doctores.update');
    Route::patch('/admin/doctores/{doctor}/toggle-activo', [App\Http\Controllers\DoctorController::class, 'toggleActivo'])->name('admin.doctores.toggleActivo');
    Route::delete('/admin/doctores/{doctor}', [App\Http\Controllers\DoctorController::class, 'destroy'])->name('admin.doctores.destroy');
});

//SUCURSALES 
use App\Http\Controllers\SucursalController;
Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('sucursales', [SucursalController::class, 'index'])
        ->name('admin.sucursales.index');

    Route::get('sucursales/create', [SucursalController::class, 'create'])
        ->name('admin.sucursales.create');

    Route::post('sucursales', [SucursalController::class, 'store'])
        ->name('admin.sucursales.store');

    Route::get('sucursales/{sucursal}/edit', [SucursalController::class, 'edit'])
        ->name('admin.sucursales.edit');

    Route::put('sucursales/{sucursal}', [SucursalController::class, 'update'])
        ->name('admin.sucursales.update');

    Route::patch('sucursales/{sucursal}/toggle', [SucursalController::class, 'toggle'])
        ->name('admin.sucursales.toggle');
});

//PACIENTES

Route::middleware(['auth'])->group(function () {
    // Rutas principales de pacientes
    Route::get('/admin/pacientes', [App\Http\Controllers\PacienteController::class, 'index'])->name('admin.pacientes.index');
    Route::get('/admin/pacientes/inactivos', [App\Http\Controllers\PacienteController::class, 'inactivos'])->name('admin.pacientes.inactivos');
    Route::get('/admin/pacientes/create', [App\Http\Controllers\PacienteController::class, 'create'])->name('admin.pacientes.create');
    Route::post('/admin/pacientes', [App\Http\Controllers\PacienteController::class, 'store'])->name('admin.pacientes.store');
    Route::get('/admin/pacientes/{paciente}', [App\Http\Controllers\PacienteController::class, 'show'])->name('admin.pacientes.show');
    Route::get('/admin/pacientes/{paciente}/edit', [App\Http\Controllers\PacienteController::class, 'edit'])->name('admin.pacientes.edit');
    Route::put('/admin/pacientes/{paciente}', [App\Http\Controllers\PacienteController::class, 'update'])->name('admin.pacientes.update');
    Route::patch('/admin/pacientes/{paciente}/toggle-activo', [App\Http\Controllers\PacienteController::class, 'toggleActivo'])->name('admin.pacientes.toggleActivo');
    Route::delete('/admin/pacientes/{paciente}', [App\Http\Controllers\PacienteController::class, 'destroy'])->name('admin.pacientes.destroy');
    
    Route::get('/admin/pacientes/{paciente}/registros', [App\Http\Controllers\PacienteController::class, 'vistaIndividual'])
    ->name('admin.pacientes.vistaIndividual');

});

//REGISTROS
Route::prefix('admin')->middleware('auth')->group(function () {

    // Rutas de Registros
    Route::get('/registros', [App\Http\Controllers\RegistroController::class, 'index'])->name('admin.registros.index');
    Route::get('/registros/create', [App\Http\Controllers\RegistroController::class, 'create'])->name('admin.registros.create');
    Route::post('/registros', [App\Http\Controllers\RegistroController::class, 'store'])->name('admin.registros.store');
    Route::get('/registros/{registro}', [App\Http\Controllers\RegistroController::class, 'show'])->name('admin.registros.show');
    Route::get('/registros/{registro}/edit', [App\Http\Controllers\RegistroController::class, 'edit'])->name('admin.registros.edit');
    Route::put('/registros/{registro}', [App\Http\Controllers\RegistroController::class, 'update'])->name('admin.registros.update');
    Route::delete('/registros/{registro}', [App\Http\Controllers\RegistroController::class, 'destroy'])->name('admin.registros.destroy');        
    Route::get('/registros/{registro}/pdf', [App\Http\Controllers\RegistroController::class, 'pdf'])->name('admin.registros.pdf');
    Route::get('/registros/{registro}/duplicar', [App\Http\Controllers\RegistroController::class, 'duplicar'])->name('admin.registros.duplicar');

    // Crear registro desde paciente
    Route::get('/registros/create/{paciente}', [App\Http\Controllers\RegistroController::class, 'createFromPaciente'])->name('admin.registros.createFromPaciente');

});

//Antecedentes patológicos
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/antecedentes_patologicos/create/{registro}', [App\Http\Controllers\AntecedentePatologicoController::class, 'create'])->name('admin.antecedentes_patologicos.create');
    Route::post('/admin/antecedentes_patologicos',[App\Http\Controllers\AntecedentePatologicoController::class, 'store'])->name('admin.antecedentes_patologicos.store');
    Route::get('/admin/antecedentes_patologicos/{antecedente}/edit',[App\Http\Controllers\AntecedentePatologicoController::class, 'edit'])->name('admin.antecedentes_patologicos.edit');
    Route::put('/admin/antecedentes_patologicos/{antecedente}',[App\Http\Controllers\AntecedentePatologicoController::class, 'update'])->name('admin.antecedentes_patologicos.update');
});

// Mostrar formulario para crear antecedente gineco de un registro
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/antecedentes_gineco_obstetricos/create/{registro}', [App\Http\Controllers\AntecedenteGinecoObstetricoController::class, 'create'])
        ->name('admin.antecedentes_gineco_obstetricos.create');
    Route::post('/admin/registros/{registro}/antecedentes_gineco',[App\Http\Controllers\AntecedenteGinecoObstetricoController::class, 'store'])->name('admin.antecedentes_gineco_obstetricos.store');
    Route::get('/admin/antecedentes_gineco/{antecedenteGineco}/edit',[App\Http\Controllers\AntecedenteGinecoObstetricoController::class, 'edit'])->name('admin.antecedentes_gineco_obstetricos.edit');
    Route::put('/admin/antecedentes_gineco/{antecedenteGineco}',[App\Http\Controllers\AntecedenteGinecoObstetricoController::class, 'update'])->name('admin.antecedentes_gineco_obstetricos.update');
    Route::get('/admin/antecedentes_gineco/{antecedenteGineco}',[App\Http\Controllers\AntecedenteGinecoObstetricoController::class, 'show'])->name('admin.antecedentes_gineco_obstetricos.show');
});

// Crear antecedente reproductivo masculino
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/antecedentes_masculinos/create/{registro}', [App\Http\Controllers\AntecedenteReproductivoMasculinoController::class, 'create'])
        ->name('admin.antecedentes_masculinos.create');
    Route::post('/admin/registros/{registro}/antecedentes_masculinos', [App\Http\Controllers\AntecedenteReproductivoMasculinoController::class, 'store'])
        ->name('admin.antecedentes_masculinos.store');
    Route::get('/admin/antecedentes_masculinos/{antecedenteMasculino}/edit', [App\Http\Controllers\AntecedenteReproductivoMasculinoController::class, 'edit'])
        ->name('admin.antecedentes_masculinos.edit');
    Route::put('/admin/antecedentes_masculinos/{antecedenteMasculino}', [App\Http\Controllers\AntecedenteReproductivoMasculinoController::class, 'update'])
        ->name('admin.antecedentes_masculinos.update');
    Route::get('/admin/antecedentes_masculinos/{antecedenteMasculino}', [App\Http\Controllers\AntecedenteReproductivoMasculinoController::class, 'show'])
        ->name('admin.antecedentes_masculinos.show');
});

// Consumo de Sustancias
Route::prefix('admin')->middleware('auth')->group(function () {
    
    Route::get('/registros/{registro}/consumos/create', [App\Http\Controllers\ConsumoSustanciaController::class, 'create'])
        ->name('admin.consumos.create'); 
    Route::post('/registros/{registro}/consumos', [App\Http\Controllers\ConsumoSustanciaController::class, 'store'])
        ->name('admin.consumos.store'); 
    Route::get('/consumos/{consumo}/edit', [App\Http\Controllers\ConsumoSustanciaController::class, 'edit'])
        ->name('admin.consumos.edit'); 
    Route::put('/consumos/{consumo}', [App\Http\Controllers\ConsumoSustanciaController::class, 'update'])
        ->name('admin.consumos.update');
});

// Constantes Vitales
Route::prefix('admin')->middleware('auth')->group(function () {
    
    Route::get('/admin/constantes_vitales/create/{registro}', [App\Http\Controllers\ConstanteVitalController::class, 'create'])
        ->name('admin.constantes_vitales.create');
    Route::post('/admin/registros/{registro}/constantes_vitales', [App\Http\Controllers\ConstanteVitalController::class, 'store'])
        ->name('admin.constantes_vitales.store');
    Route::get('/admin/constantes_vitales/{constanteVital}/edit', [App\Http\Controllers\ConstanteVitalController::class, 'edit'])
        ->name('admin.constantes_vitales.edit');
    Route::put('/admin/constantes_vitales/{constanteVital}', [App\Http\Controllers\ConstanteVitalController::class, 'update'])
        ->name('admin.constantes_vitales.update');
    Route::get('/admin/constantes_vitales/{constanteVital}', [App\Http\Controllers\ConstanteVitalController::class, 'show'])
        ->name('admin.constantes_vitales.show');
});


    // examen físico
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {

    Route::get('registros/{registro}/examenes_fisicos/create', [App\Http\Controllers\ExamenFisicoController::class, 'create'])
        ->name('examenes_fisicos.create');
    Route::post('registros/{registro}/examenes_fisicos', [App\Http\Controllers\ExamenFisicoController::class, 'store'])
        ->name('examenes_fisicos.store');
    Route::get('registros/{registro}/examenes_fisicos/edit', [App\Http\Controllers\ExamenFisicoController::class, 'edit'])
        ->name('examenes_fisicos.edit');
    Route::put('registros/{registro}/examenes_fisicos', [App\Http\Controllers\ExamenFisicoController::class, 'update'])
        ->name('examenes_fisicos.update');
    Route::get('registros/{registro}/examenes_fisicos', [App\Http\Controllers\ExamenFisicoController::class, 'show'])
        ->name('examenes_fisicos.show');
});

   // PUESTOS

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {

    Route::get('registros/{registro}/puestos/create', [App\Http\Controllers\PuestoController::class, 'create'])
        ->name('puestos.create');
    Route::post('registros/{registro}/puestos', [App\Http\Controllers\PuestoController::class, 'store'])
        ->name('puestos.store');
    Route::get('registros/{registro}/puestos/{puesto}', [App\Http\Controllers\PuestoController::class, 'show'])
        ->name('puestos.show');
    Route::get('registros/{registro}/puestos/{puesto}/edit', [App\Http\Controllers\PuestoController::class, 'edit'])
        ->name('puestos.edit');
    Route::put('registros/{registro}/puestos/{puesto}', [App\Http\Controllers\PuestoController::class, 'update'])
        ->name('puestos.update');
    Route::delete('registros/{registro}/puestos/{puesto}', [App\Http\Controllers\PuestoController::class, 'destroy'])
        ->name('puestos.destroy');

});

// centro de trabajo 

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {

    Route::get('registros/{registro}/centros/create', [App\Http\Controllers\CentroTrabajoController::class, 'create'])
        ->name('centros_trabajos.create');
    Route::post('registros/{registro}/centros', [App\Http\Controllers\CentroTrabajoController::class, 'store'])
        ->name('centros_trabajos.store');
    Route::get('registros/{registro}/centros/{centro}/edit', [App\Http\Controllers\CentroTrabajoController::class, 'edit'])
        ->name('centros_trabajos.edit');
    Route::put('registros/{registro}/centros/{centro}', [App\Http\Controllers\CentroTrabajoController::class, 'update'])
        ->name('centros_trabajos.update');
    Route::delete('registros/{registro}/centros/{centro}', [App\Http\Controllers\CentroTrabajoController::class, 'destroy'])
        ->name('centros_trabajos.destroy');
    Route::get('registros/{registro}/centros/{centro}', [App\Http\Controllers\CentroTrabajoController::class, 'show'])
        ->name('centros_trabajos.show');
});


// ACTIVIDADES EXTRAS
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('registros/{registro}/actividades_extras/create', [App\Http\Controllers\ActividadExtraController::class, 'create'])->name('actividades_extras.create');
    Route::post('registros/{registro}/actividades_extras', [App\Http\Controllers\ActividadExtraController::class, 'store'])->name('actividades_extras.store');
    Route::get('registros/{registro}/actividades_extras/{actividadExtra}', [App\Http\Controllers\ActividadExtraController::class, 'show'])->name('actividades_extras.show');
    Route::get('registros/{registro}/actividades_extras/{actividadExtra}/edit', [App\Http\Controllers\ActividadExtraController::class, 'edit'])->name('actividades_extras.edit');
    Route::put('registros/{registro}/actividades_extras/{actividadExtra}', [App\Http\Controllers\ActividadExtraController::class, 'update'])->name('actividades_extras.update');
    Route::delete('registros/{registro}/actividades_extras/{actividadExtra}', [App\Http\Controllers\ActividadExtraController::class, 'destroy'])->name('actividades_extras.destroy');
});


// Resultados de Exámenes
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::prefix('registros/{registro}')->group(function () {
        Route::get('resultados-examenes/create', [App\Http\Controllers\ResultadoExamenController::class, 'create'])
            ->name('resultados_examenes.create');
        Route::post('resultados-examenes', [App\Http\Controllers\ResultadoExamenController::class, 'store'])
            ->name('resultados_examenes.store');
        Route::get('resultados-examenes/{resultadoExamen}', [App\Http\Controllers\ResultadoExamenController::class, 'show'])
            ->name('resultados_examenes.show');
        Route::get('resultados-examenes/{resultadoExamen}/edit', [App\Http\Controllers\ResultadoExamenController::class, 'edit'])
            ->name('resultados_examenes.edit');
        Route::put('resultados-examenes/{resultadoExamen}', [App\Http\Controllers\ResultadoExamenController::class, 'update'])
            ->name('resultados_examenes.update');
        Route::delete('resultados-examenes/{resultadoExamen}', [App\Http\Controllers\ResultadoExamenController::class, 'destroy'])
            ->name('resultados_examenes.destroy');
    });
});


// Diagnostico

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::prefix('registros/{registro}')->group(function () {
        Route::get('diagnosticos/create', [App\Http\Controllers\DiagnosticoController::class, 'create'])->name('diagnosticos.create');
        Route::post('diagnosticos', [App\Http\Controllers\DiagnosticoController::class, 'store'])->name('diagnosticos.store');
        Route::get('diagnosticos/{diagnostico}', [App\Http\Controllers\DiagnosticoController::class, 'show'])->name('diagnosticos.show');
        Route::get('diagnosticos/{diagnostico}/edit', [App\Http\Controllers\DiagnosticoController::class, 'edit'])->name('diagnosticos.edit');
        Route::put('diagnosticos/{diagnostico}', [App\Http\Controllers\DiagnosticoController::class, 'update'])->name('diagnosticos.update');
        Route::delete('diagnosticos/{diagnostico}', [App\Http\Controllers\DiagnosticoController::class, 'destroy'])->name('diagnosticos.destroy');
    });
});

// APTITUD MEDICA
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::prefix('registros/{registro}')->group(function () {
        Route::get('aptitudes_medicas/create', [App\Http\Controllers\AptitudMedicaController::class, 'create'])->name('aptitudes_medicas.create');
        Route::post('aptitudes_medicas', [App\Http\Controllers\AptitudMedicaController::class, 'store'])->name('aptitudes_medicas.store');
        Route::get('aptitudes_medicas/{aptitudMedica}', [App\Http\Controllers\AptitudMedicaController::class, 'show'])->name('aptitudes_medicas.show');
        Route::get('aptitudes_medicas/{aptitudMedica}/edit', [App\Http\Controllers\AptitudMedicaController::class, 'edit'])->name('aptitudes_medicas.edit');
        Route::put('aptitudes_medicas/{aptitudMedica}', [App\Http\Controllers\AptitudMedicaController::class, 'update'])->name('aptitudes_medicas.update');
        Route::delete('aptitudes_medicas/{aptitudMedica}', [App\Http\Controllers\AptitudMedicaController::class, 'destroy'])->name('aptitudes_medicas.destroy');
    });
});

// RETIRO EVALUACIONES
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::prefix('registros/{registro}')->group(function () {
        Route::get('retiros_evaluaciones/create', [App\Http\Controllers\RetiroEvaluacionController::class, 'create'])->name('retiros_evaluaciones.create');
        Route::post('retiros_evaluaciones', [App\Http\Controllers\RetiroEvaluacionController::class, 'store'])->name('retiros_evaluaciones.store');
        Route::get('retiros_evaluaciones/{retiroEvaluacion}', [App\Http\Controllers\RetiroEvaluacionController::class, 'show'])->name('retiros_evaluaciones.show');
        Route::get('retiros_evaluaciones/{retiroEvaluacion}/edit', [App\Http\Controllers\RetiroEvaluacionController::class, 'edit'])->name('retiros_evaluaciones.edit');
        Route::put('retiros_evaluaciones/{retiroEvaluacion}', [App\Http\Controllers\RetiroEvaluacionController::class, 'update'])->name('retiros_evaluaciones.update');
        Route::delete('retiros_evaluaciones/{retiroEvaluacion}', [App\Http\Controllers\RetiroEvaluacionController::class, 'destroy'])->name('retiros_evaluaciones.destroy');
    });
});

// Certificados

use App\Http\Controllers\CertificadoController;

Route::prefix('admin')
    ->middleware('auth')
    ->name('admin.')
    ->group(function () {

    /*
    |--------------------------------------------------------------------------
    | CERTIFICADOS - CRUD GENERAL
    |--------------------------------------------------------------------------
    */

    Route::get('/certificados', [CertificadoController::class, 'index'])
        ->name('certificados.index');

    Route::get('/certificados/create', function () {
        abort(404); // Se fuerza creación solo desde paciente
    })->name('certificados.create');

    Route::post('/certificados', [CertificadoController::class, 'store'])
        ->name('certificados.store');

    Route::get('/certificados/{certificado}', [CertificadoController::class, 'show'])
        ->name('certificados.show');

    Route::get('/certificados/{certificado}/edit', [CertificadoController::class, 'edit'])
        ->name('certificados.edit');

    Route::put('/certificados/{certificado}', [CertificadoController::class, 'update'])
        ->name('certificados.update');

    Route::delete('/certificados/{certificado}', [CertificadoController::class, 'destroy'])
        ->name('certificados.destroy');

    Route::get('/certificados/{certificado}/pdf', [CertificadoController::class, 'pdf'])
        ->name('certificados.pdf');


    /*
    |--------------------------------------------------------------------------
    | CERTIFICADOS POR PACIENTE
    |--------------------------------------------------------------------------
    */

    Route::prefix('pacientes/{paciente}')
        ->group(function () {

        Route::get('/certificados', [CertificadoController::class, 'certificadosByPaciente'])
            ->name('certificados.byPaciente');

        Route::get('/certificados/create', [CertificadoController::class, 'createFromPaciente'])
            ->name('certificados.createFromPaciente');
    });
});

 // INMUNIZACIONES
// INMUNIZACIONES
use App\Http\Controllers\InmunizacionController;

Route::prefix('admin/inmunizaciones')
    ->name('admin.inmunizaciones.')
    ->middleware(['auth'])
    ->group(function () {

        // 📋 Listado general
        Route::get('/', 
            [InmunizacionController::class, 'index']
        )->name('index');

        // 👤 Inmunizaciones por paciente
        Route::get('/paciente/{paciente}', 
            [InmunizacionController::class, 'byPaciente']
        )->name('byPaciente');

        // ➕ Crear desde paciente
        Route::get('/paciente/{paciente}/crear', 
            [InmunizacionController::class, 'createFromPaciente']
        )->name('createFromPaciente');

        // 💾 Guardar
        Route::post('/', 
            [InmunizacionController::class, 'store']
        )->name('store');

        // 👁 Mostrar
        Route::get('/{inmunizacion}', 
            [InmunizacionController::class, 'show']
        )->name('show');

        // ✏️ Editar
        Route::get('/{inmunizacion}/edit', 
            [InmunizacionController::class, 'edit']
        )->name('edit');

        // 🔄 Actualizar
        Route::put('/{inmunizacion}', 
            [InmunizacionController::class, 'update']
        )->name('update');

        // 🗑 Eliminar
        Route::delete('/{inmunizacion}', 
            [InmunizacionController::class, 'destroy']
        )->name('destroy');

        // 📄 PDF
        Route::get('/{inmunizacion}/pdf', 
            [InmunizacionController::class, 'pdf']
        )->name('pdf');
    });

use App\Http\Controllers\NotaEvolucionController;

Route::prefix('admin/notas_evoluciones')
    ->name('admin.notas.')
    ->group(function () {

    // 📋 Listar notas por paciente
    Route::get('/paciente/{paciente}',
        [NotaEvolucionController::class, 'byPaciente']
    )->name('byPaciente');

    // ➕ Crear nota desde paciente
    Route::get('/paciente/{paciente}/crear',
        [NotaEvolucionController::class, 'createFromPaciente']
    )->name('createFromPaciente');

    // 💾 Guardar nota
    Route::post('/',
        [NotaEvolucionController::class, 'store']
    )->name('store');

    // 👁 Ver nota
    Route::get('/{nota}',
        [NotaEvolucionController::class, 'show']
    )->name('show');

    // ✏️ Editar nota
    Route::get('/{nota}/edit',
        [NotaEvolucionController::class, 'edit']
    )->name('edit');

    // 🔄 Actualizar nota
    Route::put('/{nota}',
        [NotaEvolucionController::class, 'update']
    )->name('update');

    // 🗑 Eliminar nota
    Route::delete('/{nota}',
        [NotaEvolucionController::class, 'destroy']
    )->name('destroy');
    
     Route::get('/paciente/{paciente}/pdf',
        [NotaEvolucionController::class, 'pdfByPaciente']
    )->name('pdfByPaciente');
});



require __DIR__.'/auth.php';
