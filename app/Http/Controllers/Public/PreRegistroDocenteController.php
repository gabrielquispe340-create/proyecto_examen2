<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreRegistroDocenteController extends Controller
{
    public function create()
    {
        $convocatoria = DB::table('convocatoria')->where('estado', 'ACTIVA')->first();
        $materias     = DB::table('materia')->orderBy('nombre')->get();

        return view('pre-registro.docente', compact('convocatoria', 'materias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'          => 'required|string|max:100',
            'apellido'        => 'required|string|max:100',
            'ci'              => 'required|string|max:20',
            'ci_extension'    => 'required|string|max:10',
            'fecha_nacimiento'=> 'required|date|before:today',
            'telefono'        => 'nullable|string|max:20',
            'email'           => 'required|email|max:150',
            'direccion'       => 'nullable|string|max:200',
            'ciudad'          => 'required|string|max:100',
            'grado_academico' => 'required|string|max:100',
            'especialidad'    => 'required|string|max:150',
            'materias'        => 'required|array|min:1',
            'materias.*'      => 'exists:materia,id',
            // Documentos
            'doc_ci'                => 'required|file|mimes:pdf,jpg,jpeg,png|max:3072',
            'doc_titulo_provision'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:3072',
            'doc_diploma_academico' => 'required|file|mimes:pdf,jpg,jpeg,png|max:3072',
            'doc_curriculum'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:3072',
            'doc_cert_no_imped'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:3072',
            'doc_planilla_materias' => 'required|file|mimes:pdf,jpg,jpeg,png|max:3072',
            'doc_certificado_item'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:3072',
        ], [
            // Mensajes para campos de texto
            'nombre.required'           => 'El campo Nombre es obligatorio. Por favor, rellénalo.',
            'nombre.string'             => 'El Nombre debe ser un texto válido.',
            'nombre.max'                => 'El Nombre no puede exceder 100 caracteres.',
            
            'apellido.required'         => 'El campo Apellido es obligatorio. Por favor, rellénalo.',
            'apellido.string'           => 'El Apellido debe ser un texto válido.',
            'apellido.max'              => 'El Apellido no puede exceder 100 caracteres.',
            
            'ci.required'               => 'El campo CI es obligatorio. Por favor, rellénalo.',
            'ci.string'                 => 'El CI debe ser un texto válido.',
            'ci.max'                    => 'El CI no puede exceder 20 caracteres.',
            
            'ci_extension.required'     => 'El campo Extensión del CI es obligatorio. Por favor, rellénalo.',
            'ci_extension.string'       => 'La Extensión debe ser un texto válido.',
            'ci_extension.max'          => 'La Extensión no puede exceder 10 caracteres.',
            
            // Mensajes para fecha
            'fecha_nacimiento.required' => 'El campo Fecha de Nacimiento es obligatorio. Por favor, rellénalo.',
            'fecha_nacimiento.date'     => 'La Fecha de Nacimiento debe ser una fecha válida.',
            'fecha_nacimiento.before'   => 'La Fecha de Nacimiento debe ser anterior a hoy.',
            
            // Mensajes para email
            'email.required'            => 'El campo Correo Electrónico es obligatorio. Por favor, rellénalo.',
            'email.email'               => 'El Correo Electrónico no es válido. Por favor, ingresa un correo válido.',
            'email.max'                 => 'El Correo no puede exceder 150 caracteres.',
            
            // Mensajes para teléfono
            'telefono.string'           => 'El Teléfono debe ser un texto válido.',
            'telefono.max'              => 'El Teléfono no puede exceder 20 caracteres.',
            
            // Mensajes para dirección
            'direccion.string'          => 'La Dirección debe ser un texto válido.',
            'direccion.max'             => 'La Dirección no puede exceder 200 caracteres.',
            
            // Mensajes para ciudad
            'ciudad.required'           => 'El campo Ciudad es obligatorio. Por favor, rellénalo.',
            'ciudad.string'             => 'La Ciudad debe ser un texto válido.',
            'ciudad.max'                => 'La Ciudad no puede exceder 100 caracteres.',
            
            // Mensajes para grado académico
            'grado_academico.required'  => 'El campo Grado Académico es obligatorio. Por favor, rellénalo.',
            'grado_academico.string'    => 'El Grado Académico debe ser un texto válido.',
            'grado_academico.max'       => 'El Grado Académico no puede exceder 100 caracteres.',
            
            // Mensajes para especialidad
            'especialidad.required'     => 'El campo Especialidad es obligatorio. Por favor, rellénalo.',
            'especialidad.string'       => 'La Especialidad debe ser un texto válido.',
            'especialidad.max'          => 'La Especialidad no puede exceder 150 caracteres.',
            
            // Mensajes para materias
            'materias.required'         => 'El campo Materias es obligatorio. Por favor, selecciona al menos una materia.',
            'materias.array'            => 'Las Materias deben ser una lista válida.',
            'materias.min'              => 'Debes seleccionar al menos una materia.',
            'materias.*.exists'         => 'Una o más materias seleccionadas no son válidas.',
            
            // Mensajes para documentos
            'doc_ci.required'               => 'El documento CI es obligatorio. Por favor, sube tu CI escaneado.',
            'doc_ci.file'                   => 'El archivo del CI debe ser un archivo válido.',
            'doc_ci.mimes'                  => 'El CI debe estar en formato PDF, JPG, JPEG o PNG.',
            'doc_ci.max'                    => 'El archivo del CI no puede exceder 3 MB.',
            
            'doc_titulo_provision.required' => 'El documento Título en Provisión Nacional es obligatorio. Por favor, súbelo.',
            'doc_titulo_provision.file'     => 'El archivo del Título debe ser un archivo válido.',
            'doc_titulo_provision.mimes'    => 'El Título debe estar en formato PDF, JPG, JPEG o PNG.',
            'doc_titulo_provision.max'      => 'El archivo del Título no puede exceder 3 MB.',
            
            'doc_diploma_academico.required'=> 'El documento Diploma Académico es obligatorio. Por favor, súbelo.',
            'doc_diploma_academico.file'    => 'El archivo del Diploma debe ser un archivo válido.',
            'doc_diploma_academico.mimes'   => 'El Diploma debe estar en formato PDF, JPG, JPEG o PNG.',
            'doc_diploma_academico.max'     => 'El archivo del Diploma no puede exceder 3 MB.',
            
            'doc_curriculum.required'       => 'El documento Curriculum Vitae es obligatorio. Por favor, súbelo.',
            'doc_curriculum.file'           => 'El archivo del CV debe ser un archivo válido.',
            'doc_curriculum.mimes'          => 'El CV debe estar en formato PDF, JPG, JPEG o PNG.',
            'doc_curriculum.max'            => 'El archivo del CV no puede exceder 3 MB.',
            
            'doc_cert_no_imped.required'    => 'El documento Certificado de No Impedimento es obligatorio. Por favor, súbelo.',
            'doc_cert_no_imped.file'        => 'El archivo del Certificado debe ser un archivo válido.',
            'doc_cert_no_imped.mimes'       => 'El Certificado debe estar en formato PDF, JPG, JPEG o PNG.',
            'doc_cert_no_imped.max'         => 'El archivo del Certificado no puede exceder 3 MB.',
            
            'doc_planilla_materias.required'=> 'El documento Planilla de Materias es obligatorio. Por favor, súbelo.',
            'doc_planilla_materias.file'    => 'El archivo de la Planilla debe ser un archivo válido.',
            'doc_planilla_materias.mimes'   => 'La Planilla debe estar en formato PDF, JPG, JPEG o PNG.',
            'doc_planilla_materias.max'     => 'El archivo de la Planilla no puede exceder 3 MB.',
            
            'doc_certificado_item.file'     => 'El archivo del Certificado debe ser un archivo válido.',
            'doc_certificado_item.mimes'    => 'El Certificado debe estar en formato PDF, JPG, JPEG o PNG.',
            'doc_certificado_item.max'      => 'El archivo del Certificado no puede exceder 3 MB.',
        ]);

        // CI duplicado en la convocatoria activa
        $convocatoria = DB::table('convocatoria')->where('estado', 'ACTIVA')->first();
        $convId = $convocatoria?->id;

        $existe = DB::table('pre_registro_docente')
            ->where('ci', $request->ci)
            ->where('ci_extension', $request->ci_extension)
            ->when($convId, fn($q) => $q->where('convocatoria_id', $convId))
            ->exists();

        if ($existe) {
            return back()
                ->withErrors(['ci' => 'Ya existe un pre-registro con ese CI en esta convocatoria.'])
                ->withInput();
        }

        // Insertar pre-registro
        $preId = DB::table('pre_registro_docente')->insertGetId([
            'convocatoria_id'  => $convId,
            'nombre'           => strtoupper(trim($request->nombre)),
            'apellido'         => strtoupper(trim($request->apellido)),
            'ci'               => trim($request->ci),
            'ci_extension'     => strtoupper(trim($request->ci_extension)),
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'telefono'         => $request->telefono,
            'email'            => strtolower(trim($request->email)),
            'direccion'        => $request->direccion,
            'ciudad'           => strtoupper(trim($request->ciudad)),
            'grado_academico'  => $request->grado_academico,
            'tiene_maestria'   => $request->boolean('tiene_maestria'),
            'tiene_diplomado'  => $request->boolean('tiene_diplomado'),
            'especialidad'     => $request->especialidad,
            'estado'           => 'PENDIENTE',
            'ip_registro'      => $request->ip(),
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        // Materias
        foreach ($request->materias as $materiaId) {
            DB::table('materia_pre_docente')->insert([
                'pre_reg_docente_id' => $preId,
                'materia_id'         => $materiaId,
            ]);
        }

        // Guardar documentos
        $mapaDocs = [
            'doc_ci'                => 'CI',
            'doc_titulo_provision'  => 'TITULO_PROVISION',
            'doc_diploma_academico' => 'DIPLOMA_ACADEMICO',
            'doc_curriculum'        => 'CURRICULUM_VITAE',
            'doc_cert_no_imped'     => 'CERT_NO_IMPEDIMENTO',
            'doc_planilla_materias' => 'PLANILLA_MATERIAS',
            'doc_certificado_item'  => 'CERTIFICADO_ITEM',
        ];

        foreach ($mapaDocs as $field => $tipo) {
            if ($request->hasFile($field)) {
                $archivo = $request->file($field);
                $nombre  = time() . '_' . $tipo . '.' . $archivo->getClientOriginalExtension();
                $ruta    = $archivo->storeAs("pre_registro/docentes/{$request->ci}", $nombre, 'public');

                DB::table('doc_pre_docente')->insert([
                    'pre_reg_docente_id' => $preId,
                    'tipo'               => $tipo,
                    'nombre_archivo'     => $nombre,
                    'ruta_servidor'      => $ruta,
                    'mime_type'          => $archivo->getMimeType(),
                    'tamanio_bytes'      => $archivo->getSize(),
                    'created_at'         => now(),
                ]);
            }
        }

        return redirect()->route('pre-registro.docente.exito', [
            'nombre' => strtoupper($request->nombre),
            'ci'     => $request->ci,
        ]);
    }

    public function exito(Request $request)
    {
        return view('pre-registro.docente-exito', [
            'nombre' => $request->query('nombre', 'Docente'),
            'ci'     => $request->query('ci', '—'),
        ]);
    }
}