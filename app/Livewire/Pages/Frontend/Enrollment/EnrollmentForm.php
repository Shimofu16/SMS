<?php

namespace App\Livewire\Pages\Frontend\Enrollment;

use App\Models\Student;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\GradeLevel;
use Livewire\Attributes\Layout;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Contracts\HasForms;
use App\Enums\EnrollmentStudentTypeEnum;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use App\Enums\StudentEnrollmentStatusEnum;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Validation\ValidationException;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Str;

#[Layout('layouts.app')]
class EnrollmentForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public  $school_year;

    public function mount(): void
    {
        $this->form->fill();
        $this->school_year = getCurrentSetting();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Student Information')
                        ->schema([
                            TextInput::make('lrn')
                                ->label('Learner\'s Reference Number')
                                ->numeric()
                                ->length(12)
                                ->required()
                                ->columnSpanFull(),
                            TextInput::make('first_name')
                                ->autocapitalize('words')
                                ->required(),
                            TextInput::make('middle_name')
                                ->autocapitalize('words')
                                ->required(),
                            TextInput::make('last_name')
                                ->autocapitalize('words')
                                ->required(),
                            TextInput::make('ext_name')
                                ->autocapitalize('words'),
                            Select::make('gender')
                                ->options([
                                    'male' => 'Male',
                                    'female' => 'Female',
                                ])
                                ->required(),
                            DatePicker::make('birthday')
                                ->before(now())
                                ->required(),
                            TextInput::make('email')
                                ->email()
                                ->required(),
                            TextInput::make('address')
                                ->required(),
                            Select::make('grade_level_id')
                                ->label('Grade Level')
                                ->options(GradeLevel::pluck('name', 'id'))
                                ->required(),
                            Select::make('student_type')
                                ->options(EnrollmentStudentTypeEnum::toArray(['old student']))
                                ->required(),

                        ])
                        ->columns(2),
                    Wizard\Step::make('Parents Information')
                        ->schema([
                            TextInput::make('father_name')
                                ->label('Father\'s name')
                                ->autocapitalize('words')
                                ->required(),
                            DatePicker::make('father_birthday')
                                ->label('Father\'s birthday')
                                ->before(now())
                                ->required(),
                            TextInput::make('father_phone')
                                ->label('Father\'s phone number')
                                ->required(),
                            TextInput::make('father_occupation')
                                ->label('Father\'s occupation')
                                ->required(),
                            TextInput::make('mother_name')
                                ->label('Mother\'s name')
                                ->autocapitalize('words')
                                ->required(),
                            DatePicker::make('mother_birthday')
                                ->label('Mother\'s birthday')
                                ->before(now())
                                ->required(),
                            TextInput::make('mother_phone')
                                ->label('Mother\'s phone number')
                                ->required(),
                            TextInput::make('mother_occupation')
                                ->label('Mother\'s occupation')
                                ->required(),
                        ])
                        ->columns(2),
                    Wizard\Step::make('Documents')
                        ->schema([
                            FileUpload::make('photo')
                                ->image()
                                ->avatar()
                                ->disk('public')
                                ->directory('documents')
                                ->required()
                                ->columnSpanFull(),
                            FileUpload::make('form_138')
                                ->image()
                                ->disk('public')
                                ->directory('documents')
                                ->required()
                                ->columnSpanFull(),
                            FileUpload::make('birth_certificate')
                                ->image()
                                ->disk('public')
                                ->directory('documents')
                                ->required()
                                ->columnSpanFull(),
                            FileUpload::make('good_moral_certification')
                                ->image()
                                ->disk('public')
                                ->directory('documents')
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                    // Wizard\Step::make('Payments')
                    //     ->schema([

                    //     ])
                    //     ->columns(2),
                ])
                    // ->startOnStep(4)
                    ->nextAction(
                        fn (Action $action) => $action
                            ->button()
                            ->outlined()
                            ->label('Next step'),
                    )
                    ->submitAction(new HtmlString('
                <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Submit
                </button>
                '))
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $setting = getCurrentSetting();
        try {
            $student = $this->createStudent($data, $setting);
            $this->createEnrollment($student, $data, $setting);
            $this->createFamilyMembers($student, $data);

            Notification::make()
                ->title('Successfully submitted the data')
                ->body('Thank you for enrolling! Please wait for the validation of your enrollment. :)')
                ->success()
                ->duration(5000)
                ->send();
        } catch (\Throwable $th) {
            Notification::make()
                ->title('Error on submitting data')
                ->body($th->getMessage())
                ->danger()
                ->duration(5000)
                ->send();
        }
    }

    private function createStudent($data, $setting)
    {
        return Student::create([
            'school_id' => generateSchoolId($setting),
            'lrn' => $data['lrn'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'ext_name' => $data['ext_name'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'birthday' => $data['birthday'],
            'address' => $data['address'],
        ]);
    }

    private function createEnrollment($student, $data, $setting)
    {

        $department = getDepartment($data['grade_level_id']);

        $student->enrollments()->create([
            'grade_level_id' => $data['grade_level_id'],
            'school_year_id' => $setting->school_year_id,
            'student_type' => EnrollmentStudentTypeEnum::NEW->value,
            'department' => $department,
            'documents' => [
                'birth_certificate' => $data['birth_certificate'],
                'form_138' => $data['form_138'],
                'good_moral_certification' => $data['good_moral_certification'],
                'photo' => $data['photo'],
            ],
            'status' => StudentEnrollmentStatusEnum::PENDING->value,
        ]);
    }

    private function createFamilyMembers($student, $data)
    {
        $student->familyMembers()->create([
            'name' => $data['father_name'],
            'birthday' => $data['father_birthday'],
            'phone' =>  $data['father_phone'],
            'occupation' => $data['father_occupation'],
            'relationship' => 'Father'
        ]);
        $student->familyMembers()->create([
            'name' => $data['mother_name'],
            'birthday' => $data['mother_birthday'],
            'phone' =>  $data['mother_phone'],
            'occupation' => $data['mother_occupation'],
            'relationship' => 'Mother'
        ]);
    }

    private function getDepartment($grade_level_id)
    {
        if ($grade_level_id <= 6) {
            return 'Elementary';
        } elseif ($grade_level_id <= 9) {
            return 'Junior High';
        } else {
            return 'Senior High';
        }
    }


    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->danger()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.pages.frontend.enrollment.enrollment-form');
    }
}
