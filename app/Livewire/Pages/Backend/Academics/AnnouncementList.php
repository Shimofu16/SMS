<?php

namespace App\Livewire\Pages\Backend\Academics;

use App\Enums\RoleEnum;
use App\Enums\RuleEnum;
use App\Models\Announcement;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AnnouncementList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public static function table(Table $table): Table
    {
        $setting = getCurrentSetting();
        return $table
            ->headerActions([
                CreateAction::make()
                    ->button()
                    ->createAnother(false)
                    ->form([
                        Section::make()
                            ->schema([
                                TextInput::make('title')
                                    ->required(),
                                Textarea::make('body')
                                    ->required(),
                                Select::make('send_to_roles')
                                    ->multiple()
                                    ->required()
                                    ->options(
                                        RoleEnum::toArray()
                                    ),
                                FileUpload::make('attachments')
                                    ->multiple()
                                    ->disk('public')
                                    ->directory('attachments')


                            ]),

                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        //    dd($data['send_to_roles'],$data['attachments']);
                        $attachments = [];
                        $roles = [];
                        foreach ($data['attachments'] as $key => $attachment) {
                            $attachments[] = $attachment;
                        }
                        foreach ($data['send_to_roles'] as $key => $role) {
                            $roles[] = $role;
                        }
                        $data['send_to_roles'] = $roles;
                        $data['attachments'] = $attachments;
                        return $data;
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Successfully Created')
                            ->body('Announcement has been created successfully.'),
                    ),
            ])
            ->query(
                Announcement::query()
                    ->withoutGlobalScopes([
                        SoftDeletingScope::class,
                    ])
            )
            ->columns([
                TextColumn::make('title')
                    ->description(fn (Announcement $record): string => $record->body)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->date()
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                ViewAction::make()
                    ->infolist(
                        function (Infolist $infolist): Infolist {
                            return $infolist
                                ->schema([
                                    ComponentsSection::make()
                                        ->schema([
                                            TextEntry::make('title'),
                                            TextEntry::make('body'),

                                            ViewEntry::make('attachments')
                                                ->view('infolists.components.files')
                                        ])
                                ]);
                        }
                    ),
                EditAction::make()
                    ->form([
                        Section::make()
                            ->schema([
                                TextInput::make('title')
                                    ->required(),
                                Textarea::make('body')
                                    ->required(),
                                Select::make('send_to_roles')
                                    ->multiple()
                                    ->required()
                                    ->options(
                                        RoleEnum::toArray()
                                    ),
                                FileUpload::make('attachments')
                                    ->multiple()
                                    ->disk('public')
                                    ->directory('attachments')


                            ]),
                    ])
                    // ->mutateRecordDataUsing(function (array $data): array {
                    //     $data['classes'] = ScheduleClass::where('schedule_id', $data['id'])->get()->toArray();

                    //     return $data;
                    // })
                    // ->mutateFormDataUsing(function (array $data): array {
                    //     $subjectName = Subject::find($data['subject_id'])->name;
                    //     $data['code'] = strtoupper(str_replace(['a', 'e', 'i', 'o', 'u'], '', $subjectName));

                    //     return $data;
                    // })
                    // ->using(function (Model $record, array $data): Model {
                    //     $classes = $data['classes'];
                    //     foreach ($classes as $key => $class) {
                    //         ScheduleClass::find($class['id'])->update([
                    //             'date' => $class['date'],
                    //             'start' => $class['start'],
                    //             'end' => $class['end'],
                    //         ]);
                    //     }
                    //     $record->update($data);

                    //     return $record;
                    // })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Successfully Updated')
                            ->body('Schedule has been updated successfully.'),
                    ),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
    public function render(): View
    {
        return view('livewire.pages.backend.academic-settings.announcement');
    }
}
